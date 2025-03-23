<?php
class Asistencia extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado'])|| ($_SESSION['usuario_autenticado'] != "true")) { 
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        if($_SESSION['nivel'] ==5){
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        
    }
    public function index()
    {
        if($_SESSION['nivel'] !==1 && $_SESSION['nivel'] !==100){
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }

        $data['title'] = 'Hoja de Asistencia';
        $data1 = '';
        
        $this->views->getView('Administracion', "Asistencia", $data, $data1);
    }
    public function listar()
    {
       
        
        $data = $this->model->getCargos();
        for ($i = 0; $i < count($data); $i++) {

            $datonuevo = $data[$i]['estado'];
            if ($datonuevo == 'Activo') {
                $data[$i]['estado'] = "<div class='badge badge-info'>Activo</div>";
            } else {
                $data[$i]['estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            }

            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="editUser(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
           
            </div>';
            // <button class="btn btn-danger" type="button" onclick="ViewUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // <button class="btn btn-danger" type="button" onclick="DeleteUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // colocar eliminar si es necesario
        }
        echo json_encode($data);
        die();
    }

    public function registrar()
    {
        
        if (isset($_POST['id'])||isset($_POST['justificacion']) ) {
            $id = $_POST['id'];
            $justificacion = $_POST['justificacion'];

            
                $data = $this->model->modificarJustificacion($justificacion,$id);
                if($data >0){
                    $respuesta = ['msg' => 'Se ha Actualizado su Justificacion', 'icono' => 'success'];
                }else{
                    $respuesta = ['msg' => 'Se ha Producido un error', 'icono' => 'warning'];
                }
        }else{
            $respuesta = ['msg' => 'todo los campos son requeridos', 'icono' => 'warning'];
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
    //eliminar user
    public function edit($id)
    {
        if (is_numeric($id)) {
            $data = $this->model->edit($id);
            $respuesta = $data;
            
        } else {
            $respuesta = ['msg' => 'error desconocido', 'icono' => 'error'];
        }
        echo json_encode($respuesta);
        die();
    }

    public function listarTrabajadorAsistencia(){
      
        $dayNames = [
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
            "Domingo",
          ];

          
          if (isset($_POST['id'])) {
            $id = $_POST['id'] ;
        }else{
            $id= $_SESSION['id'];
            $data = $this->model->getusuario($id);
            $id = $data['trabajador_id'];
        }

        // $fecha = new DateTime();
        // $anio = $fecha->format("Y");
        $anio = date("Y");


        $data = $this->model->getAllAsistenciasTrabajador($id,$anio);

        for ($i = 0; $i < count($data); $i++) {
            // $data[$i]['cantidad']= $i+1;
         
            $fecha  = $data[$i]['fecha'];
            $fecha_nueva = new DateTime($fecha);
           
            $fecha_invertida = date('d-m-Y', strtotime($fecha));
    
            $diaSemana0to6 = $fecha_nueva->format("N");
            $dia = $dayNames[$diaSemana0to6-1];
           
            

            $data[$i]['dia'] = $dia;
            if($data[$i]['licencia']=='SR'){
                $data[$i]['licencia']='Sin Marcacion';
            }
            if($data[$i]['licencia']=='NMS'){
                $data[$i]['licencia']='No Marco Salida';
            }
            if($data[$i]['tardanza_cantidad']=='0'){
                $data[$i]['tardanza_cantidad']='-';
            }

            
            $data[$i]['fecha'] = $fecha_invertida;

            
            


        }

      
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    public function listarTrabajadorAsistenciaGeneral(){
        
        $dayNames = [
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
            "Domingo",
          ];
            $id = $_POST['id'] ;
            $anio = date("Y");


        $data = $this->model->getAllAsistenciasTrabajador($id,$anio);

        for ($i = 0; $i < count($data); $i++) {
            // $data[$i]['cantidad']= $i+1;
         
            $fecha  = $data[$i]['fecha'];
            $fecha_nueva = new DateTime($fecha);
           
            $fecha_invertida = date('d-m-Y', strtotime($fecha));
    
            $diaSemana0to6 = $fecha_nueva->format("N");
            $dia = $dayNames[$diaSemana0to6-1];
           
            

            $data[$i]['dia'] = $dia;
            if($data[$i]['licencia']=='SR'){
                $data[$i]['licencia']='Sin Marcacion';
            }
            if($data[$i]['licencia']=='NMS'){
                $data[$i]['licencia']='No Marco Salida';
            }
            if($data[$i]['tardanza_cantidad']=='0'){
                $data[$i]['tardanza_cantidad']='-';
            }

            
            $data[$i]['fecha'] = $fecha_invertida;
        }

      
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        
        
        
    }
    public function listaCalendarioAsistenciaTrabajador()
    {
        // $id = 812;
        // $anio = '2024';
        // $mes = '5';
      
        if (isset($_POST['id']) && isset($_POST['anio']) && isset($_POST['mes'])) {
            $mes = $_POST['mes'] ; 
            $anio = $_POST['anio'] ; 
            $id = $_POST['id'] ;
            if (is_numeric($id)) {
                // Llama al modelo para obtener los datos de asistencia
                $data = $this->model->getAsistenciaPorFecha($id, $anio, $mes);
    
                // Devuelve los datos como JSON
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
                
            } else {
                // Si el ID no es numérico, devuelve un mensaje de error
                echo json_encode(['error' => 'El ID no es válido']);
            }
        } else {
            // Si no se recibieron todos los datos esperados, devuelve un mensaje de error
            echo json_encode(['error' => 'Se requieren los parámetros "id", "anio" y "mes"']);
        }
    
        // Detiene la ejecución del script
        die();
    }

    public function ver()
    {

    
        $id= $_SESSION['id'];
        $data1 = $this->model->getusuario($id);
        $id = $data1['trabajador_id'];
        $data1['id']=$id;
        $data['title'] = 'Hoja de Asistencia';
        // $data1 = '';
        
        $this->views->getView('Administracion', "Asistencia_Trabajador", $data, $data1);
    }

   
}
