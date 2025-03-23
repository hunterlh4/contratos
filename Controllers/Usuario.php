<?php
class Usuario extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        if ($_SESSION['nivel'] !== 1 &&  $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
    }
    public function index()
    {

        // $data = $this->model->getUsuarioId($_SESSION['id']);
        $data['title'] = 'Usuarios';
        // $data1="";

        // $data1 = $this->model->getTrabajadores();
        $data1 = '';
        $this->views->getView('Administracion', "Usuario", $data, $data1);
    }
    public function listar()
    {
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['contador'] = $i + 1;
            // $datonuevo = $data[$i]['usuario_estado'];
            // if ($datonuevo == 1) {
            //     $data[$i]['usuario_estado'] = "<div class='badge badge-info'>Activo</div>";
            // }
            // if ($datonuevo == 0) {
            //     $data[$i]['usuario_estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            // }
            // if ($datonuevo == 2) {
            //     $data[$i]['usuario_estado'] = "<div class='badge badge-warning'>Pendiente</div>";
            // }
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-icon btn-sm btn-secondary" type="button" onclick="editUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-briefcase"></i></button>
            <button class="btn btn-icon btn-sm btn-secondary" type="button" onclick="editUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-icon btn-sm btn-secondary" type="button" onclick="editUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-archive"></i></button>
            <button class="btn btn-icon btn-sm btn-secondary" type="button" onclick="editUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-clock"></i></button>

            </div>';
            // <button class="btn btn-danger" type="button" onclick="ViewUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // <button class="btn btn-danger" type="button" onclick="DeleteUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // colocar eliminar si es necesario

        }
        echo json_encode($data);
        die();
    }

    public function listar2()
    {
        $data = $this->model->getUsuarios2();

        echo json_encode($data);
        die();
    }

    public function listartrabajadores()
    {
        $data1 = $this->model->getTrabajadores();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }



    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['username'] ?? '';
            // $nombre = $_POST['nombre'] ?? '';
            // $apellido = $_POST['apellido'] ?? '';
            $sistema = $_POST['sistema'] ?? '';
            $password = $_POST['password'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $personal_id = $_POST['personal'] ?? '';
            $rol_id = $_POST['rol'] ?? '';
            // $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            // $dni = $_POST['dni'] ?? '';
            $id = $_POST['id'] ?? '';

            $error_msg = '';
            $hash = password_hash($password, PASSWORD_DEFAULT);


            $datos_adicionales = array(
                "usuario" => $usuario,
                "password" => $password,
                // "nombre" => $nombre,
                // "apellido" => $apellido,
                "sistema" => $sistema,
                "personal_id" => $personal_id,
                "estado" => $estado
            );
            $datos_adicionales_json = json_encode($datos_adicionales);

            $accion = $id ? 'editar' : 'crear';

            if (empty($personal_id)) {
                $error_msg .= 'El <b>personal</b> es obligatorio.<br>';
            }
            if (empty($rol_id)) {
                $error_msg .= "Debes seleccionar una dirección.<br>";
            }
            if (empty($usuario)) {
                $error_msg .= 'El <b>Usuario</b> es obligatorio.<br>';
            }
            if ($accion == 'crear' && empty($password)) {
                $error_msg .= 'El <b>Contraseña</b> es obligatorio.<br>';
            }
            // if (empty($nombre)) {
            //     $error_msg .= 'El <b>Nombre</b> es obligatorio.<br>';
            // }
            // if (empty($apellido)) {
            //     $error_msg .= 'El <b>Apellido</b> es obligatorio.<br>';
            // }
            if (empty($sistema)) {
                $error_msg .= 'El <b>sistema</b> es obligatorio.<br>';
            }
            // if (!preg_match('/^[a-zA-Z0-9]{5,20}$/', $usuario) && $usuario) {
            //     $error_msg .= 'El "usuario" debe tener entre 5 y 16 caracteres y solo contener letras y números.<br>';
            // }


            // Validación del usuario

            $result = $this->model->verificarUsuario($usuario);

            if (($accion == 'crear' && !empty($result)) || ($accion == 'editar' && !empty($result) && $result['id'] != $id)) {
                $error_msg .= 'El <b>Usuario</b> ya existe.<br>';
            }

            if (!empty($password) && (strlen($password) < 5 || strlen($password) > 20)) {
                $error_msg .= 'El campo "Contraseña" debe tener entre 5 y 20 caracteres.<br>';
            }

            if (!empty($error_msg)) {
                echo json_encode(["icono" => "error", "msg" => $error_msg]);
                exit;
            }

            if ($accion == 'crear') {
                $data = $this->model->registrar($usuario, $hash, $sistema, $personal_id, $rol_id);
                if ($data > 0) {
                    $respuesta = ['msg' => 'usuario registrado', 'icono' => 'success'];
                    // $this->model->registrarlog($_SESSION['id'], 'Crear', 'Usuario', $datos_adicionales_json);
                    // $this->actualizar($trabajador_id, $nombre, $apellido, $dni, $fecha_nacimiento, $rol_id);
                } else {
                    $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
                }
            }
            if ($accion == 'editar') {
                $clave = $this->model->getUsuario($id);
                if ($personal_id == '0') {
                    $personal_id = null;
                }
                if (empty($password)) {
                    $hash = $clave['password'];
                }
                $data = $this->model->modificar($usuario, $hash, $sistema, $personal_id, $estado, $rol_id, $id);
                // $this->actualizarTrabajador($trabajador_id, $nombre, $apellido, $dni, $fecha_nacimiento, $rol_id);
                if ($data == 1) {
                    $respuesta = ['msg' => 'Usuario modificado', 'icono' => 'success'];
                    // $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Usuario', $datos_adicionales_json);
                } else {
                    $respuesta = ['msg' => 'Error al modificar el usuario', 'icono' => 'error'];
                }
            }

            echo json_encode($respuesta);
            exit;
        }
        die();
    }
    //eliminar user
    public function delete($idUser)
    {
        if (is_numeric($idUser)) {
            $data = $this->model->eliminar($idUser);
            if ($data == 1) {
                $respuesta = array('msg' => 'usuario dado de baja', 'icono' => 'success');
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
    public function edit($idUser)
    {
        if (is_numeric($idUser)) {
            $data1 = $this->model->getUsuario($idUser);
            // $data2 = $this->model->getTrabajadoresconBuscar($idUser);
            // $response = [
            //     'usuario' => $data1,
            //     'trabajadores' => $data2
            // ];
            echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function actualizarTrabajador($trabajador_id, $nombre, $apellido, $dni, $nacimiento, $rol_id)
    {

        $this->model->modificarTrabajador($nombre, $apellido, $dni, $nacimiento, $rol_id, $trabajador_id);
    }
}
