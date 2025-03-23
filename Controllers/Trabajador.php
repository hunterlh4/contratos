<?php
class Trabajador extends Controller
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
        if($_SESSION['nivel'] !==1 &&  $_SESSION['nivel'] !==100){
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Trabajador';

        $this->views->getView('Administracion', "Trabajador", $data);
    }


    public function listar()
    {
        
     
        $data = $this->model->getTrabajadores();

        for ($i = 0; $i < count($data); $i++) {
            $data_estado = $data[$i]['testado'];
            $data_cargo = $data[$i]['cnombre'];
            $data_regimen = $data[$i]['rnombre'];
            if ($data_cargo == 'SIN ASIGNAR') {
                $data[$i]['cnombre'] = '-';
            }
            if ($data_regimen == 'SIN ASIGNAR') {
                $data[$i]['rnombre'] = '-';
            }
            if ($data_estado == 'Activo') {
                $data[$i]['estado'] = "<div class='badge badge-info'>Activo</div>";
            } else {
                $data[$i]['estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            }
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['tid'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger" type="button" onclick="verHistorial(' . $data[$i]['tid'] . ')"><i class="fas fa-eye"></i></button>
            </div>';
        }
        echo json_encode($data);
        return $data;
    }

    public function listarActivo()
    {
        $data = $this->model->getAllTrabajador();


        echo json_encode($data);
        return $data;
    }

    public function listarDireccion()
    {
        $data1 = $this->model->getDireccion();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarCargo()
    {
        $data1 = $this->model->getCargo();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarHorarioDetalle()
    {
        $data1 = $this->model->getHorario();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarRegimen()
    {
        $data1 = $this->model->getRegimen();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dni = $_POST['dni'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $tarjeta = $_POST['tarjeta'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $nacimiento = $_POST['nacimiento'] ?? '';
            $sexo = $_POST['sexo'] ?? '';
            $direccion_id = $_POST['direccion'] ?? '';
            $regimen_id = $_POST['regimen'] ?? '';
            $cargo_id = $_POST['cargo'] ?? '';
            $modalidad = $_POST['modalidad'] ?? '';
            $horario_id = $_POST['horario'] ?? '';
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
            if (empty($apellido)) {
                $error_msg .= 'El campo <b>Apellido</b> es obligatorio.<br>';
            }
            if (empty($nacimiento)) {
                $error_msg .= 'El campo <b>Fecha de nacimiento</b> es obligatorio.<br>';
            }
            if (empty($sexo)) {
                $error_msg .= 'El campo <b>Sexo</b> es obligatorio.<br>';
            }
            if (empty($direccion_id)) {
                $error_msg .= 'El campo <b>Dirección</b> es obligatorio.<br>';
            }
            if (empty($regimen_id)) {
                $error_msg .= 'El campo <b>Régimen</b> es obligatorio.<br>';
            }
            if (empty($cargo_id)) {
                $error_msg .= 'El campo <b>Cargo</b> es obligatorio.<br>';
            }
            if (empty($modalidad)) {
                $error_msg .= 'El campo <b>Modalidad</b> es obligatorio.<br>';
            }
            if (empty($horario_id)) {
                $error_msg .= 'El campo <b>Horario</b> es obligatorio.<br>';
            }
            if (empty($estado)) {
                $error_msg .= 'El campo <b>Estado</b> es obligatorio.<br>';
            }
            if ((strlen($nombre) < 3 || strlen($nombre) > 30) && $nombre) {
                $error_msg .= 'El <b>Nombre</b> debe tener entre 3 y 30 caracteres. <br>';
            }
            if ((strlen($apellido) < 3 || strlen($apellido) > 30) && $apellido) {
                $error_msg .= 'El <b>Apellido</b> debe tener entre 3 y 30 caracteres. <br>';
            }
            if (((strlen($tarjeta) < 5 || strlen($tarjeta) > 40)) && $tarjeta) {
                $error_msg .= 'El <b>Telefono</b> debe tener 9 digitos.<br>';
            }
            if (((strlen($email) < 5 || strlen($email) > 40)) && $email) {
                $error_msg .= 'El <b>email</b> debe tener 9 digitos.<br>';
            }
            if (((strlen($telefono) < 9) || (strlen($telefono) > 12)) && $telefono) {
                $error_msg .= 'El <b>telefono</b>  debe tener 9 digitos.<br>';
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
                "tarjeta" => $tarjeta,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "email" => $email,
                "nacimiento" => $nacimiento,
                "sexo" => $sexo,
                "direccion_id" => $direccion_id,
                "regimen_id" => $regimen_id,
                "cargo_id" => $cargo_id,
                "modalidad" => $modalidad,
                "horarioDetalle_id" => $horario_id,
                "id" => $id,
                "estado" => $estado,

            );
            $datos_log_json = json_encode($datos_log);

            $data = $this->model->modificar($dni, $nombre, $apellido, $direccion_id, $regimen_id, $horario_id, $cargo_id, $email, $telefono, $tarjeta, $sexo, $nacimiento, $modalidad, $estado, $id);
            if ($data == 1) {
                $respuesta = ['msg' => 'Trabajador modificado', 'icono' => 'success'];
                $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Trabajador', $datos_log_json);
            } else {
                $respuesta = ['msg' => 'Error al modificar', 'icono' => 'error'];
            }
            echo json_encode($respuesta);




            // if (empty($nacimiento)) {
            //     $nacimiento = null;
            //     // $nacimiento_convertido = 'vacio';
            // } else {
            //     $nacimiento = date('Y-m-d', strtotime($_POST['nacimiento']));
            // }



            // if ((empty($nombre)) || (empty($dni)) || (empty($direccion_id)) || (empty($cargo_id)) || (empty($modalidad)) || (empty($horario_id)) || (empty($regimen_id))) {
            //     $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            // } else {
            //     $error_msg = '';
            //     if (strlen($nombre) < 3 || strlen($nombre) > 50) {
            //         $error_msg .= 'El Nombre debe tener entre 3 y 50 caracteres. <br>';
            //     }
            //     if (!empty($tarjeta)) {
            //         if ((strlen($tarjeta) < 5 || strlen($tarjeta) > 40)) {
            //             $error_msg .= 'El telefono debe tener 9 digitos.<br>';
            //         }
            //     }
            //     if (!empty($email)) {
            //         if ((strlen($nombre) < 5 || strlen($nombre) > 40)) {
            //             $error_msg .= 'El telefono debe tener 9 digitos.<br>';
            //         }
            //     }
            //     if (!empty($telefono)) {
            //         if (((strlen($telefono) < 9) || (strlen($telefono) > 12))) {
            //             $error_msg .= 'El telefono debe tener 9 digitos.<br>';
            //         }
            //     }



            //     if (!empty($error_msg)) {

            //         $respuesta = array('msg' => $error_msg, 'icono' => 'warning');
            //     } else {
            //         // VERIFICO LA EXISTENCIA
            //         $result = $this->model->verificar($dni);
            //         // REGISTRAR
            //         if (empty($id)) {
            //             if (empty($result)) {
            //                 $data = $this->model->registrar($dni, $nombre, $direccion_id, $regimen_id, $horario_id, $cargo_id, $email, $telefono, $tarjeta, $sexo, $nacimiento, $modalidad);

            //                 if ($data > 0) {
            //                     $respuesta = array('msg' => 'Trabajador registrado', 'icono' => 'success');
            //                     $this->model->registrarlog($_SESSION['id'], 'Crear', 'Trabajador', $datos_log_json);
            //                 } else {
            //                     $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
            //                 }
            //             } else {
            //                 $respuesta = array('msg' => 'Trabajador en uso', 'icono' => 'warning');
            //             }
            //             // MODIFICAR
            //         } else {
            //             if ($result) {
            //                 if ($result['id'] != $id) {
            //                     $respuesta = array('msg' => 'DNI en uso', 'icono' => 'warning');
            //                 } else {

            //                     // COLOCAR AQUI VALIDADOR QUE AL MODIFICAR DE ACTIVO A INACTIVO CAMBIE A NULL
            //                     // El nombre de usuario es el mismo que el original, se permite la modificación
            //                     $data = $this->model->modificar($dni, $nombre, $apellido, $direccion_id, $regimen_id, $horario_id, $cargo_id, $email, $telefono, $tarjeta, $sexo, $nacimiento, $modalidad, $estado, $id);
            //                     if ($data == 1) {
            //                         $respuesta = array('msg' => 'Trabajador modificado', 'icono' => 'success');
            //                         $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Trabajador', $datos_log_json);
            //                     } else {
            //                         $respuesta = array('msg' => 'Error al modificar', 'icono' => 'error');
            //                     }
            //                 }
            //             } else {
            //                 // El usuario no existe, se permite la modificación
            //                 $data = $this->model->modificar($dni, $nombre, $apellido, $direccion_id, $regimen_id, $horario_id, $cargo_id, $email, $telefono, $tarjeta, $sexo, $nacimiento, $modalidad, $estado, $id);
            //                 if ($data == 1) {
            //                     $respuesta = array('msg' => 'Trabajador modificado', 'icono' => 'success');
            //                     $this->model->registrarlog($_SESSION['id'], 'Modificar', 'Trabajador', $datos_log_json);
            //                 } else {
            //                     $respuesta = array('msg' => 'Error al modificar el Trabajador', 'icono' => 'error');
            //                 }
            //             }
            //         }
            //     }
            // }

            // echo json_encode($respuesta);
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
            $data = $this->model->getTrabajador($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function verHistorial($id)
    {
        if (is_numeric($id)) {
            $_SESSION['id_seguimiento_trabajador'] = $id;
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
