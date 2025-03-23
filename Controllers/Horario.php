<?php
class Horario extends Controller
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
        
        
        $data['title'] = 'Horarios';
        $data1 = '';
        $this->views->getView('Administracion', "Horario", $data, $data1);
    }
    public function listar()
    {
        $data = $this->model->getHorarios();
        for ($i = 0; $i < count($data); $i++) {

            $datonuevo = $data[$i]['estado'];
          
           
            if ($datonuevo == 'Activo') {
                $data[$i]['estado'] = "<div class='badge badge-info'>Activo</div>";
            } else {
                $data[$i]['estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            }
            
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="Edit(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="sendId(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button>

            
            </div>';
            // <button class="btn btn-danger" type="button" onclick="ViewUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // <button class="btn btn-danger" type="button" onclick="DeleteUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // colocar eliminar si es necesario
        }
        echo json_encode($data);
        die();
    }

    public function temporal($id){
        // $new_id = (int)$id;
        // $data['title'] = 'Horarios';
        // $data1 = '';
        $_SESSION['id_horario'] =  $id  ;
        // header('Location: ' . BASE_URL . 'HorarioDetalle');
        exit(); 
     
    }

    public function registrar()
    {
        if ((isset($_POST['nombre']))){

            $nombre = $_POST['nombre'];
            $comentario = $_POST['comentario'];
            $estado = $_POST['estado'];
            $id = $_POST['id'];

            $datos_log = array(
                "nombre" => $nombre,
                "comentario" => $comentario,
                "estado" => $estado,
               
            );
            $datos_log_json = json_encode($datos_log);

            if (empty($nombre)) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $error_msg = '';
                if (strlen($nombre) < 3 || strlen($nombre) > 50) {
                    $error_msg .= 'El Horario debe tener entre 3 y 50 caracteres. <br>';
                }
                if(!empty($comentario)){
                    if (strlen($comentario) <= 5 ) {
                        $error_msg .= 'El comentario debe de ser mas grande.<br>';
                    }
                }

                if (!empty($error_msg)) {
                    
                    $respuesta = array('msg' => $error_msg, 'icono' => 'warning');
                } else {
                    // VERIFICO LA EXISTENCIA
                    $result = $this->model->verificar($nombre);
                    // REGISTRAR
                    if (empty($id)) {
                        if (empty($result)) {
                            $data = $this->model->registrar($nombre,$comentario);

                            if ($data > 0) {
                                $respuesta = array('msg' => 'Horario registrado', 'icono' => 'success');
                                $this->model->registrarlog($_SESSION['id'],'Crear','Horario', $datos_log_json);
                            } else {
                                $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                            }
                        } else {
                            $respuesta = array('msg' => 'Horario en uso', 'icono' => 'warning');
                        }
                        // MODIFICAR
                    } else {
                        if ($result) {
                            if ($result['id'] != $id) {
                                $respuesta = array('msg' => 'Horario en uso', 'icono' => 'warning');
                            } else {

                                // COLOCAR AQUI VALIDADOR QUE AL MODIFICAR DE ACTIVO A INACTIVO CAMBIE A NULL
                                // El nombre de usuario es el mismo que el original, se permite la modificación
                                $data = $this->model->modificar($nombre,$comentario, $estado, $id);
                                if ($data == 1) {
                                    $respuesta = array('msg' => 'Horario modificado', 'icono' => 'success');
                                    $this->model->registrarlog($_SESSION['id'],'Modificar','Horario', $datos_log_json);
                                } else {
                                    $respuesta = array('msg' => 'Error al modificar', 'icono' => 'error');
                                }
                            }
                        } else {
                            // El usuario no existe, se permite la modificación
                            $data = $this->model->modificar($nombre,$comentario, $estado, $id);
                            if ($data == 1) {
                                $respuesta = array('msg' => 'Horario modificado', 'icono' => 'success');
                                $this->model->registrarlog($_SESSION['id'],'Modificar','Horario', $datos_log_json);
                            } else {
                                $respuesta = array('msg' => 'Error al modificar el Horario', 'icono' => 'error');
                            }
                        }
                    }
                }
            }
            
            echo json_encode($respuesta);
        }
     
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
            $data = $this->model->getHorario($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
