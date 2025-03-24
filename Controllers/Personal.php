<?php
class Personal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
    }
    public function index()
    {
        if ($_SESSION['nivel'] !== 1 &&  $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Personal';

        $this->views->getView('Administracion', "Personal", $data);
    }


    public function listar()
    {


        $data = $this->model->getPersonales();

        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['contador'] = $i + 1;
            $data_apellido_paterno = $data[$i]['personal_apellido_paterno'];
            $data_apellido_paterno = $data[$i]['personal_apellido_materno'];
            $data[$i]['personal_apellido'] = trim($data[$i]['personal_apellido_paterno'] . ' ' . ($data[$i]['personal_apellido_materno'] ?? ''));


            // $data_cargo = $data[$i]['cnombre'];
            // $data_cargo = $data[$i]['rnombre'];
            // if ($data_cargo == 'SIN ASIGNAR') {
            //     $data[$i]['cnombre'] = '-';
            // }
            // if ($data_cargo == 'SIN ASIGNAR') {
            //     $data[$i]['rnombre'] = '-';
            // }
            // if ($data_estado == 'Activo') {
            //     $data[$i]['estado'] = "<div class='badge badge-info'>Activo</div>";
            // } else {
            //     $data[$i]['estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            // }
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['personal_id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="verHistorial(' . $data[$i]['personal_id'] . ')"><i class="fas fa-eye"></i></button>
            </div>';
        }
        echo json_encode($data);
        return $data;
    }

    public function listarActivo()
    {
        $data = $this->model->getAllActivo();


        echo json_encode($data);
        return $data;
    }

    public function listararea()
    {
        $data1 = $this->model->getarea();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    // public function listarCargo()
    // {
    //     $data1 = $this->model->getCargo();

    //     echo json_encode($data1, JSON_UNESCAPED_UNICODE);
    //     die();
    // }

    public function listarHorarioDetalle()
    {
        $data1 = $this->model->getHorario();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    // public function listarcargo()
    // {
    //     $data1 = $this->model->getcargo();

    //     echo json_encode($data1, JSON_UNESCAPED_UNICODE);
    //     die();
    // }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = $_POST['dni'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $celular = $_POST['celular'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $apellido_paterno = $_POST['apellido_paterno'] ?? '';
            $apellido_materno = $_POST['apellido_materno'] ?? '';
            $email = $_POST['email'] ?? '';
            // $nacimiento = $_POST['nacimiento'] ?? '';
            // $sexo = $_POST['sexo'] ?? '';
            $area_id = $_POST['area'] ?? '';
            $cargo_id = $_POST['cargo'] ?? '';


            $estado = $_POST['estado'] ?? '';
            $id = $_POST['id'] ?? '';

            // validaciones
            $error_msg = '';
            if (empty($dni)) {
                $error_msg .= 'El campo <b>DNI</b> es obligatorio.<br>';
            }
            if (!preg_match('/^\d{8}$/', $dni)) {
                $error_msg .= "El DNI debe tener exactamente 8 dígitos.<br>";
            }
            // if (empty($telefono)) {
            //     $error_msg .= 'El campo <b>Teléfono</b> es obligatorio.<br>';
            // }
            if (empty($nombre)) {
                $error_msg .= 'El campo <b>Nombre</b> es obligatorio.<br>';
            }
            if (empty($apellido_paterno)) {
                $error_msg .= 'El campo <b>Apellido</b> es obligatorio.<br>';
            }

            // if (empty($nacimiento)) {
            //     $error_msg .= 'El campo <b>Fecha de nacimiento</b> es obligatorio.<br>';
            // }
            // if (empty($sexo)) {
            //     $error_msg .= 'El campo <b>Sexo</b> es obligatorio.<br>';
            // }

            if (empty($email)) {
                $error_msg .= 'El campo <b>Correo</b> es obligatori111o.<br>';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_msg .= 'El <b>Correo</b> no es válido.<br>';
            }
            if (empty($area_id)) {
                $error_msg .= 'El campo <b>Area</b> es obligatorio.<br>';
            }

            if (empty($cargo_id)) {
                $error_msg .= 'El campo <b>Cargo</b> es obligatorio.<br>';
            }

            // if (empty($estado)) {
            //     $error_msg .= 'El campo <b>Estado</b> es obligatorio.<br>';
            // }
            if ((strlen($nombre) < 3 || strlen($nombre) > 30) && $nombre) {
                $error_msg .= 'El <b>Nombre</b> debe tener entre 3 y 30 caracteres. <br>';
            }
            if ((strlen($apellido_paterno) < 3 || strlen($apellido_paterno) > 30) && $apellido_paterno) {
                $error_msg .= 'El <b>Apellido</b> debe tener entre 3 y 30 caracteres. <br>';
            }
            // if (((strlen($tarjeta) < 5 || strlen($tarjeta) > 40)) && $tarjeta) {
            //     $error_msg .= 'El <b>Telefono</b> debe tener 9 digitos.<br>';
            // }
            if (((strlen($email) < 5 || strlen($email) > 40)) && $email) {
                $error_msg .= 'El <b>email</b> debe tener 9 digitos.<br>';
            }
            if (((strlen($telefono) > 0) || (strlen($telefono) > 12)) && $telefono) {
                $error_msg .= 'El <b>telefono</b>  debe tener 9 digitos.<br>';
            }
            if (((strlen($celular) > 0) && (strlen($celular) > 12)) && $celular) {
                $error_msg .= 'El <b>celular</b>  debe tener 9 digitos.<br>';
            }
            $result = $this->model->verificar($dni);

            if (!empty($result) && $result['id'] != $id) {
                $error_msg .= 'El <b>DNI</b> en uso.<br>';
            }
            if (!empty($error_msg)) {
                echo json_encode(["icono" => "error", "msg" => $error_msg]);
                exit;
            }

            $datos_log = array(
                "dni" => $dni,
                "telefono" => $telefono,
                // "tarjeta" => $tarjeta,
                "nombre" => $nombre,
                // "apellido" => $apellido,
                "email" => $email,
                // "nacimiento" => $nacimiento,
                // "sexo" => $sexo,
                "area_id" => $area_id,
                "cargo_id" => $cargo_id,
                // "cargo_id" => $cargo_id,
                // "modalidad" => $modalidad,
                // "horarioDetalle_id" => $horario_id,
                "id" => $id,
                "estado" => $estado,

            );
            $datos_log_json = json_encode($datos_log);

            if (empty($id)) {
                $data = $this->model->registrar($dni, $nombre, $apellido_paterno, $apellido_materno, $area_id, $cargo_id, $email, $telefono, $celular);
                if ($data > 0) {
                    $respuesta = ['msg' => 'Personal registrado', 'icono' => 'success'];
                    // $this->model->createLog($_SESSION['id'], 'Crear', 'Festividades', $datos_log_json);
                } else {
                    $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
                }
                echo json_encode($respuesta);
                die();
            } else {
                $data = $this->model->modificar($dni, $nombre, $apellido_paterno, $apellido_materno, $area_id, $cargo_id, $email, $telefono, $celular, $estado, $id);
                if ($data == 1) {
                    $respuesta = ['msg' => 'Personal modificado', 'icono' => 'success'];
                    // $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Personal', $datos_log_json);
                } else {
                    $respuesta = ['msg' => 'Error al modificar', 'icono' => 'error'];
                }
                echo json_encode($respuesta);
                die();
            }
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
            $data = $this->model->getPersonal($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function verHistorial($id)
    {
        if (is_numeric($id)) {
            $_SESSION['id_seguimiento_Personal'] = $id;
        }
        die();
    }

    public function obtenerDatosPorDNI($dni)
    {
        if ((empty($dni)) || (!(strlen($dni) == 8))) {
            // Manejo del error si el DNI está vacío o no tiene la longitud esperada
        } else {
            $token = 'apis-token-8285.mKhIxulHCg46xmhD1LwgiS-jfiftQR6i';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 2,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Referer: https://apis.net.pe/consulta-dni-api',
                    'Authorization: Bearer ' . $token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            // Devolver la respuesta sin modificar, ya que es un JSON válido
            echo $response;
        }
        die();
    }
}
