<?php
class Banco extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        // aqui va permiso para quitar la vista
        // if ($_SESSION['nivel'] == 5) {
        //     header('Location: ' . BASE_URL . 'errors');
        //     exit;
        // }
    }
    public function index()
    {
        $data['title'] = 'Banco';
        $data['nivel'] =  $_SESSION['nivel'];
        $data1 = '';
        $this->views->getView('Administracion', "Banco", $data, $data1);
    }



    public function listar()
    {

        $data = $this->model->listar();

        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['contador'] = $i + 1;

            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
         
            </div>';
        }
        echo json_encode($data);
        return $data;
    }

    // function listarReceptor()
    // {
    //     if (isset($_POST['emisor_id'])) {

    //         $emisor_id = $_POST['emisor_id'];


    //         $data = $this->model->listarReceptor($emisor_id);


    //         echo json_encode($data, JSON_UNESCAPED_UNICODE);
    //     } else {

    //         $respuesta = ['msg' => 'error', 'icono' => 'error'];
    //         echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    //     }

    //     // Detiene la ejecución del script
    //     die();
    // }



    // public function registrar()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //         $tipo_Banco = $_POST['tipo_Banco'] ?? null;
    //         $nombre = $_POST['nombre'] ?? '';
    //         $dni = $_POST['dni'] ?? null;
    //         $ruc = $_POST['ruc'] ?? null;
    //         $direccion = $_POST['direccion'] ?? null;
    //         $celular = $_POST['celular'] ?? null;
    //         $email = $_POST['email'] ?? null;
    //         $ubigeo = $_POST['ubigeo'] ?? null;
    //         $estado = $_POST['estado'] ?? '';
    //         $id = $_POST['id'] ?? '';



    //         $datos_log = [
    //             "nombre" => $nombre,
    //             // "comentario" => $descripcion,
    //             "estado" => $estado,

    //         ];
    //         $datos_log_json = json_encode($datos_log);


    //         $error_msg = '';
    //         if (empty($tipo_Banco)) {
    //             $error_msg .= 'El campo <b>tipo Banco</b> es obligatori111o.<br>';
    //         }
    //         if (empty($nombre)) {
    //             $error_msg .= 'El campo <b>nombre</b> es obligatori111o.<br>';
    //         }
    //         if (strlen($nombre) < 5 || strlen($nombre) > 50) {
    //             $error_msg .= 'El Banco debe tener entre 3 y 50 caracteres. <br>';
    //         }
    //         if (empty($direccion)) {
    //             $error_msg .= 'El campo <b>direccion</b> es obligatori111o.<br>';
    //         }
    //         if (empty($ubigeo)) {
    //             $error_msg .= 'El campo <b>ubigeo</b> es obligatori111o.<br>';
    //         }

    //         if (empty($email)) {
    //             $error_msg .= 'El campo <b>Correo</b> es obligatori111o.<br>';
    //         }

    //         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //             $error_msg .= 'El <b>Correo</b> no es válido.<br>';
    //         }



    //         if (!empty($dni)) {
    //             $result = $this->model->verificardni($dni);
    //             if (!empty($result) && $result['id'] != $id) {
    //                 $error_msg .= 'El <b>DNI</b> está en uso.<br>';
    //             }
    //         }

    //         if (!empty($ruc)) {
    //             $result = $this->model->verificarruc($ruc);
    //             if (!empty($result) && $result['id'] != $id) {
    //                 $error_msg .= 'El <b>RUC</b> está en uso.<br>';
    //             }
    //         }

    //         if (!empty($error_msg)) {
    //             echo json_encode(["icono" => "error", "msg" => $error_msg]);
    //             exit;
    //         }

    //         // $datos_log = array(
    //         //     "dni" => $dni,
    //         //     "telefono" => $telefono,
    //         //     // "tarjeta" => $tarjeta,
    //         //     "nombre" => $nombre,
    //         //     // "apellido" => $apellido,
    //         //     "email" => $email,
    //         //     // "nacimiento" => $nacimiento,
    //         //     // "sexo" => $sexo,
    //         //     "area_id" => $area_id,
    //         //     "cargo_id" => $cargo_id,
    //         //     // "cargo_id" => $cargo_id,
    //         //     // "modalidad" => $modalidad,
    //         //     // "horarioDetalle_id" => $horario_id,
    //         //     "id" => $id,
    //         //     "estado" => $estado,

    //         // );
    //         // $datos_log_json = json_encode($datos_log);

    //         if (empty($id)) {
    //             $data = $this->model->registrar($tipo_Banco, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular);
    //             if ($data > 0) {
    //                 echo json_encode(['msg' => 'Banco registrada', 'icono' => 'success']);
    //             } else {
    //                 echo json_encode(['msg' => 'Error al registrar', 'icono' => 'error']);
    //             }
    //         } else {
    //             $data = $this->model->modificar($tipo_Banco, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id);
    //             if ($data == 1) {
    //                 echo json_encode(['msg' => 'Banco modificada', 'icono' => 'success']);
    //             } else {
    //                 echo json_encode(['msg' => 'Error al modificar', 'icono' => 'error']);
    //             }
    //         }
    //         die();
    //     } else {
    //         echo json_encode(['msg' => 'Todos los campos son requeridos', 'icono' => 'warning']);
    //     }
    // }

    // public function eliminar($id)
    // {
    //     if (is_numeric($id)) {
    //         $data = $this->model->findOneById($id);
    //         if (empty($data)) {
    //             $respuesta = ['msg' => 'No se ha podido encontrar', 'icono' => 'error'];
    //         }
    //         if ($data['tipo'] == 'feriado') {
    //             $respuesta = ['msg' => 'No esta permitido borrar feriados', 'icono' => 'warning'];
    //         }
    //         if ($data['tipo'] == 'institucional') {
    //             $data = $this->model->delete($id);
    //             if ($data) {
    //                 $respuesta = ['msg' => 'Calendario Actualizado', 'icono' => 'success'];
    //             }
    //             if (empty($data)) {
    //                 $respuesta = ['msg' => 'Ocurrio un error', 'icono' => 'error'];
    //             }
    //         }
    //     }
    //     echo json_encode($respuesta);
    //     die();
    // }

    // //eliminar user
    // public function delete($id)
    // {
    //     if (is_numeric($id)) {
    //         $data = $this->model->eliminar($id);
    //         if ($data == 1) {
    //             $respuesta = ['msg' => 'se ha dado de baja', 'icono' => 'success'];
    //         } else {
    //             $respuesta = ['msg' => 'error al eliminar', 'icono' => 'error'];
    //         }
    //     } else {
    //         $respuesta = ['msg' => 'error desconocido', 'icono' => 'error'];
    //     }
    //     echo json_encode($respuesta);
    //     die();
    // }
    // //editar user
    // public function edit($id)
    // {
    //     if (is_numeric($id)) {
    //         $data = $this->model->buscar($id);
    //         echo json_encode($data, JSON_UNESCAPED_UNICODE);
    //     }
    //     die();
    // }




}
