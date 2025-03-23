<?php
class HorarioDetalle extends Controller
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

        $data['title'] = 'Horario Detalle';

        $this->views->getView('Administracion', "HorarioDetalle", $data);
    }
    public function listar()
    {
        if (empty($_SESSION['id_horario'])) {
            $data = $this->model->getHorarioDetalles();
           
        } else {
            $id =  $_SESSION['id_horario'];
            $data = $this->model->getHorarioDetallesPorHorario($id);
        }
        for ($i = 0; $i < count($data); $i++) {

            $datonuevo = $data[$i]['estado'];


            if ($datonuevo == 'Activo') {
                $data[$i]['estado'] = "<div class='badge badge-info'>Activo</div>";
            } else {
                $data[$i]['estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            }

            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="Edit(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>

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
        if ((isset($_POST['nombre']))) {

            $nombre = $_POST['nombre'];
            $entrada = $_POST['entrada'];
            $salida = $_POST['salida'];
            $estado = $_POST['estado'];
            $total = $_POST['total'];
            $id = $_POST['id'];

            if(empty($_SESSION['id_horario'])){
                $horario_id = 'vacio';
            }else{
                $horario_id =  $_SESSION['id_horario'];
            }
            

            $datos_log = array(
                "nombre" => $nombre,
                "horario_id" => $horario_id,
                "entrada" => $entrada,
                "salida" => $salida,
                "total" => $total,
                "estado" => $estado,

            );
            $datos_log_json = json_encode($datos_log);

            if ((empty($nombre) || (empty($entrada) || (empty($salida)) ))) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $error_msg = '';
                if (strlen($nombre) < 5 || strlen($nombre) > 50) {
                    $error_msg .= 'El Horario debe tener entre 5 y 50 caracteres. <br>';
                }
                if($horario_id=='vacio'){
                    $error_msg .= 'Debe de Seleccionar Un Horario para Agregar un Detalle. <br>';
                }

                if (!empty($error_msg)) {

                    $respuesta = array('msg' => $error_msg, 'icono' => 'warning');
                } else {
                    // VERIFICO LA EXISTENCIA
                    
                    // AQUI VEO LA DIFERENCIA DE HORARIOS

                    // REGISTRAR
                    if (empty($id)) {

                        $data = $this->model->registrar($nombre, $horario_id, $entrada, $salida,$total);

                        if ($data > 0) {
                            $respuesta = array('msg' => 'Detalle registrado', 'icono' => 'success');
                            $this->model->registrarlog($_SESSION['id'], 'Crear', 'Horario Detalle', $datos_log_json);
                        } else {
                            $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                        }
                        // MODIFICAR
                    } else {
                        // COLOCAR AQUI VALIDADOR QUE AL MODIFICAR DE ACTIVO A INACTIVO CAMBIE A NULL
                        // El nombre de usuario es el mismo que el original, se permite la modificación
                        $data = $this->model->modificar($nombre, $horario_id, $entrada, $salida,$total, $estado, $id);
                        if ($data == 1) {
                            $respuesta = array('msg' => 'Detalle modificado', 'icono' => 'success');
                            $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Horario Detalle', $datos_log_json);
                        } else {
                            $respuesta = array('msg' => 'Error al modificar', 'icono' => 'error');
                        }
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
            $data = $this->model->getHorarioDetalle($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
