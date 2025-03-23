<?php
class Seguimiento extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        if($_SESSION['nivel'] !==1 &&  $_SESSION['nivel'] !==100){
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
    }
    public function index()
    {
      

        $data['title'] = 'Seguimiento';

        $this->views->getView('Administracion', "Seguimiento", $data);
    }
    public function listar()
    {
        if (empty($_SESSION['id_seguimiento_trabajador'])) {
            $data = $this->model->getSeguimientos();
        
        } else {
            $id =  $_SESSION['id_seguimiento_trabajador'];
            $data = $this->model->getSeguimientoPorTrabajador($id);
        }
        for ($i = 0; $i < count($data); $i++) {

            // $datonuevo = $data[$i]['documento'];
            $data[$i]['documento_descarga'] = '<a href="'.BASE_URL.'Uploads/Contrato/'.$data[$i]['documento'].'"  class="btn btn-success" title="'.$data[$i]['documento'].'"  Target="_blank">
            <i class="fas fa-file-alt"></i>  </a>' ;
            

            $inicio = $data[$i]['fecha_inicio'];
            $fin = $data[$i]['fecha_fin'];

            if(!empty($inicio)){
                $inicio = date('d-m-Y', strtotime($inicio));
                $data[$i]['fecha_inicio_2'] = $inicio;
            }else{
                $data[$i]['fecha_inicio_2'] = '';
            }
            if(!empty($fin)){
                $fin = date('d-m-Y', strtotime($fin));
                $data[$i]['fecha_fin_2'] = $fin;
            }else{
                $data[$i]['fecha_inicio_2'] = '';
            }

            $datonuevo = $data[$i]['estado'];
            if ($datonuevo == 'Activo') {
                $data[$i]['estado'] = "<div class='badge badge-info'>Activo</div>";
            } else {
                $data[$i]['estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            }

            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>

            </div>';
            // <button class="btn btn-danger" type="button" onclick="ViewUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // <button class="btn btn-danger" type="button" onclick="DeleteUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // colocar eliminar si es necesario
        }
        echo json_encode($data);
        return $data;
    }

    public function registrar()
    {
        if ((isset($_POST['direccion']))) {

            $regimen = $_POST['regimen'];
            $direccion = $_POST['direccion'];
            $cargo = $_POST['cargo'];
            $documento = $_FILES['archivo']['name'];;
            $sueldo = $_POST['sueldo'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $estado = $_POST['estado'];
            $id = $_POST['id'];
            $nombreArchivoActual = $_POST['nombreArchivoActual'];
            
            if(empty($_SESSION['id_seguimiento_trabajador'])){
                $trabajador_id = 'vacio';
            }else{
                $trabajador_id =  $_SESSION['id_seguimiento_trabajador'];
            }

         

            if (empty($fecha_inicio)) {
                $fecha_inicio = null;
                // $inicio = 'vacio';
            }else{
                $fecha_inicio = date('d-m-Y', strtotime($_POST['fecha_inicio']));
                
            }

            if (empty($fecha_fin)) {
                $fecha_fin = null;
                
            }else{
                $fecha_fin = date('d-m-Y', strtotime($_POST['fecha_fin']));
                
            }
            date_default_timezone_set('America/Lima');
            $fechaActual = date('Y-m-d_H-i-s');
           
            


          

            if (((empty($regimen)) || (empty($direccion)) || (empty($cargo))  || (empty($sueldo)) || (empty($fecha_inicio)) || (empty($fecha_fin)) )) {
                $respuesta = array('msg' =>'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $error_msg = '';
                if (strlen($sueldo) < 2 || strlen($sueldo) > 7) {
                    $error_msg .= 'Ingrese un sueldo diferente. <br>';
                }
                if($trabajador_id=='vacio'){
                    $error_msg .= 'Debe de Seleccionar Un Trabajador para Agregar un Seguimiento. <br>';
                }

                if (!empty($error_msg)) {

                    $respuesta = array('msg' => $error_msg, 'icono' => 'warning');
                }  else {
                    // VERIFICO LA EXISTENCIA
                   
                    // AQUI VEO LA DIFERENCIA DE HORARIOS
                  
                    // REGISTRAR
                    if (empty($id)) {

                        if ($_FILES['archivo']['error'] === 0) {
                            $nombreArchivo = $_FILES['archivo']['name'];
                            $tipoArchivo = $_FILES['archivo']['type'];
                            // Obtener la extensión del archivo
                            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                            if ($extension === 'pdf') {
                                // Acceder a la información del archivo
                                // $tamañoArchivo = $_FILES['archivo']['size'];
                                $rutaTemporal = $_FILES['archivo']['tmp_name'];
                        
                                // Hacer algo con el archivo, como moverlo a una ubicación deseada
                                $nombreArchivo = $fechaActual .'_'.$_SESSION['id'].'.'.$extension;
                                move_uploaded_file($rutaTemporal, 'Uploads/Contrato/' . $nombreArchivo);

                                $data = $this->model->registrar($trabajador_id,$regimen,$direccion, $cargo,$nombreArchivo,$sueldo,$fecha_inicio,$fecha_fin);

                                $datos_log = array(
                                    "id" => $id,
                                    "trabajador_id" => $trabajador_id,
                                    "regimen" => $regimen,
                                    "direccion" => $direccion,
                                    "cargo" => $cargo,
                                    "documento" => $nombreArchivo,
                                    "sueldo" => $sueldo,
                                    "fecha_inicio" => $fecha_inicio,
                                    "fecha_fin" => $fecha_fin,
                                    "estado" => $estado,
                    
                                );
                                $datos_log_json = json_encode($datos_log);

                                if ($data > 0) {
                                    $respuesta = array('msg' => 'Seguimiento registrado', 'icono' => 'success');
                                    $this->model->registrarlog($_SESSION['id'], 'Crear', 'Seguimiento', $datos_log_json);
                                } else {
                                    $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                                }
                            } else {
                                
                                $respuesta = array('msg' => 'El Archivo debe de ser un PDF', 'icono' => 'warning');
                            }
                        } else{
                            $respuesta = array('msg' => 'Debe de Seleccionar un Archivo', 'icono' => 'error');
                        }
                          $datos_log = array(
                                "id" => $id,
                                "trabajador_id" => $trabajador_id,
                                "regimen" => $regimen,
                                "direccion" => $direccion,
                                "cargo" => $cargo,
                                "documento" => $documento,
                                "sueldo" => $sueldo,
                                "fecha_inicio" => $fecha_inicio,
                                "fecha_fin" => $fecha_fin,
                                "estado" => $estado,

                            );
                            $datos_log_json = json_encode($datos_log);

                       
                        // MODIFICAR
                    } else {
                        $result = $this->model->verificar($id);
                        $nombreArchivo2 = $result['documento'];

                        $borrar = "Uploads/Contrato/".$nombreArchivo2;
                        // $respuesta = array('msg' => $nombreArchivo2, 'icono' => 'error');

                        if (($_FILES['archivo']['error'] === 0)) {
                            $nombreArchivo = $_FILES['archivo']['name'];
                            $tipoArchivo = $_FILES['archivo']['type'];
                            // Obtener la extensión del archivo
                            $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                            if ($extension === 'pdf') {
                                // Acceder a la información del archivo
                                // $tamañoArchivo = $_FILES['archivo']['size'];
                                $rutaTemporal = $_FILES['archivo']['tmp_name'];
                                // $nombreArchivoConruta =$nombreArchivo.'.'.$tipoArchivo;
                               
                                $nombreArchivo = $fechaActual .'_'.$_SESSION['id'].'.'.$extension;
                             
                                    
                                    if (file_exists($borrar)) {
                                        unlink($borrar);
                                       
                                        move_uploaded_file($rutaTemporal, 'Uploads/Contrato/' . $nombreArchivo);
                                       
                                    }else{
                                        move_uploaded_file($rutaTemporal, 'Uploads/Contrato/' . $nombreArchivo);
                                    }

                                    $data = $this->model->modificar($trabajador_id,$regimen,$direccion, $cargo,$nombreArchivo,$sueldo,$fecha_inicio,$fecha_fin, $estado, $id);


                                    $datos_log = array(
                                        "id" => $id,
                                        "trabajador_id" => $trabajador_id,
                                        "regimen" => $regimen,
                                        "direccion" => $direccion,
                                        "cargo" => $cargo,
                                        "documento" => $nombreArchivo,
                                        "sueldo" => $sueldo,
                                        "fecha_inicio" => $fecha_inicio,
                                        "fecha_fin" => $fecha_fin,
                                        "estado" => $estado,
            
                                    );
                                    $datos_log_json = json_encode($datos_log);
                                    $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Seguimiento', $datos_log_json);
                                    if ($data == 1) {
                                        $respuesta = array('msg' => 'Detalle modificado', 'icono' => 'success');
                                       
                                    } else {
                                        $respuesta = array('msg' => 'Error al modificar', 'icono' => 'error');
                                    }
                            }
                        }else{
                            $data = $this->model->modificarSinArchivo($trabajador_id,$regimen,$direccion, $cargo,$sueldo,$fecha_inicio,$fecha_fin, $estado, $id);

                            $datos_log = array(
                                "id" => $id,
                                "trabajador_id" => $trabajador_id,
                                "regimen" => $regimen,
                                "direccion" => $direccion,
                                "cargo" => $cargo,
                                "documento" => $nombreArchivoActual,
                                "sueldo" => $sueldo,
                                "fecha_inicio" => $fecha_inicio,
                                "fecha_fin" => $fecha_fin,
                                "estado" => $estado,
    
                            );
                            $datos_log_json = json_encode($datos_log);
                            
                            $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Seguimiento', $datos_log_json);
                            
                            if ($data == 1) {
                                $respuesta = array('msg' => 'Detalle modificado', 'icono' => 'success');

                               
                            } else {
                                $respuesta = array('msg' => 'Error al modificar', 'icono' => 'error');
                            }
                           
                        }

                        // COLOCAR AQUI VALIDADOR QUE AL MODIFICAR DE ACTIVO A INACTIVO CAMBIE A NULL
                        // El nombre de usuario es el mismo que el original, se permite la modificación
                       
                      
                    }
                }
            }
        }

        echo json_encode($respuesta);


        die();
    }
    //eliminar user
    public function delete($id)
    {
        if (is_numeric($id)) {
            $data = $this->model->eliminar($id);
            if ($data == 1) {
                $respuesta = array('msg' => 'se ha dado de baja', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }
    //editar user
    public function edit($id)
    {
        if (is_numeric($id)) {
            $data = $this->model->getSeguimiento($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

   
}
