<?php
class Contrato extends Controller
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
        $data['title'] = 'Contrato';
        $data['nivel'] =  $_SESSION['nivel'];
        $data1 = '';
        $this->views->getView('Administracion', "Contrato_Solicitud", $data, $data1);
    }
    public function Nuevo_Arrendamiento()
    {
        $data['title'] = 'Contrato de Arrendamiento';
        $data['nivel'] =  $_SESSION['nivel'];
        $data1 = '';
        $this->views->getView('Administracion', "Contrato_Arrendamiento_nuevo", $data, $data1);
    }
    public function Nuevo_LocacionServicio()
    {
        $data['title'] = 'Contrato de Locacion de Servicios';
        $data['nivel'] =  $_SESSION['nivel'];
        $data1 = '';
        $this->views->getView('Administracion', "Contrato_Locacion_nuevo", $data, $data1);
    }
    public function Nuevo_Mandato()
    {
        $data['title'] = 'Contrato de Mandato Mandato';
        $data['nivel'] =  $_SESSION['nivel'];
        $data1 = '';
        $this->views->getView('Administracion', "Contrato_Mandato_nuevo", $data, $data1);
    }
    public function Nuevo_MutuoDinero()
    {
        $data['title'] = 'Contrato de Mutuo de Dinero';
        $data['nivel'] =  $_SESSION['nivel'];
        $data1 = '';
        $this->views->getView('Administracion', "Contrato_Mutuo_nuevo", $data, $data1);
    }

    public function ver()
    {
        $data['title'] = 'Contrato';
        $data['nivel'] =  $_SESSION['nivel'];
        $data1 = '';
        $this->views->getView('Administracion', "Contrato", $data, $data1);
    }

    public function listar()
    {

        $data = $this->model->getContratos();

        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['contador'] = $i + 1;

            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['contrato_id'] . ')"><i class="fas fa-edit"></i></button>
               <button class="btn btn-danger" type="button" onclick="view(' . $data[$i]['contrato_id'] . ')"><i class="fas fa-eye"></i></button>
            </div>';
        }
        echo json_encode($data);
        return $data;
    }



    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $tipo_Contrato = $_POST['tipo_Contrato'] ?? null;
            $nombre = $_POST['nombre'] ?? '';
            $dni = $_POST['dni'] ?? null;
            $ruc = $_POST['ruc'] ?? null;
            $direccion = $_POST['direccion'] ?? null;
            $celular = $_POST['celular'] ?? null;
            $email = $_POST['email'] ?? null;
            $ubigeo = $_POST['ubigeo'] ?? null;
            $estado = $_POST['estado'] ?? '';
            $id = $_POST['id'] ?? '';



            $datos_log = [
                "nombre" => $nombre,
                // "comentario" => $descripcion,
                "estado" => $estado,

            ];
            $datos_log_json = json_encode($datos_log);


            $error_msg = '';
            if (empty($tipo_Contrato)) {
                $error_msg .= 'El campo <b>tipo Contrato</b> es obligatori111o.<br>';
            }
            if (empty($nombre)) {
                $error_msg .= 'El campo <b>nombre</b> es obligatori111o.<br>';
            }
            if (strlen($nombre) < 5 || strlen($nombre) > 50) {
                $error_msg .= 'El Contrato debe tener entre 3 y 50 caracteres. <br>';
            }
            if (empty($direccion)) {
                $error_msg .= 'El campo <b>direccion</b> es obligatori111o.<br>';
            }
            if (empty($ubigeo)) {
                $error_msg .= 'El campo <b>ubigeo</b> es obligatori111o.<br>';
            }

            if (empty($email)) {
                $error_msg .= 'El campo <b>Correo</b> es obligatori111o.<br>';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_msg .= 'El <b>Correo</b> no es válido.<br>';
            }



            if (!empty($dni)) {
                $result = $this->model->verificardni($dni);
                if (!empty($result) && $result['id'] != $id) {
                    $error_msg .= 'El <b>DNI</b> está en uso.<br>';
                }
            }

            if (!empty($ruc)) {
                $result = $this->model->verificarruc($ruc);
                if (!empty($result) && $result['id'] != $id) {
                    $error_msg .= 'El <b>RUC</b> está en uso.<br>';
                }
            }

            if (!empty($error_msg)) {
                echo json_encode(["icono" => "error", "msg" => $error_msg]);
                exit;
            }

            // $datos_log = array(
            //     "dni" => $dni,
            //     "telefono" => $telefono,
            //     // "tarjeta" => $tarjeta,
            //     "nombre" => $nombre,
            //     // "apellido" => $apellido,
            //     "email" => $email,
            //     // "nacimiento" => $nacimiento,
            //     // "sexo" => $sexo,
            //     "area_id" => $area_id,
            //     "cargo_id" => $cargo_id,
            //     // "cargo_id" => $cargo_id,
            //     // "modalidad" => $modalidad,
            //     // "horarioDetalle_id" => $horario_id,
            //     "id" => $id,
            //     "estado" => $estado,

            // );
            // $datos_log_json = json_encode($datos_log);

            if (empty($id)) {
                $data = $this->model->registrar($tipo_Contrato, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular);
                if ($data > 0) {
                    echo json_encode(['msg' => 'Contrato registrada', 'icono' => 'success']);
                } else {
                    echo json_encode(['msg' => 'Error al registrar', 'icono' => 'error']);
                }
            } else {
                $data = $this->model->modificar($tipo_Contrato, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id);
                if ($data == 1) {
                    echo json_encode(['msg' => 'Contrato modificada', 'icono' => 'success']);
                } else {
                    echo json_encode(['msg' => 'Error al modificar', 'icono' => 'error']);
                }
            }
            die();
        } else {
            echo json_encode(['msg' => 'Todos los campos son requeridos', 'icono' => 'warning']);
        }
    }

    public function eliminar($id)
    {
        if (is_numeric($id)) {
            $data = $this->model->findOneById($id);
            if (empty($data)) {
                $respuesta = ['msg' => 'No se ha podido encontrar', 'icono' => 'error'];
            }
            if ($data['tipo'] == 'feriado') {
                $respuesta = ['msg' => 'No esta permitido borrar feriados', 'icono' => 'warning'];
            }
            if ($data['tipo'] == 'institucional') {
                $data = $this->model->delete($id);
                if ($data) {
                    $respuesta = ['msg' => 'Calendario Actualizado', 'icono' => 'success'];
                }
                if (empty($data)) {
                    $respuesta = ['msg' => 'Ocurrio un error', 'icono' => 'error'];
                }
            }
        }
        echo json_encode($respuesta);
        die();
    }
    public function actualizarCalendar()
    {
        if (isset($_POST['nombre']) && isset($_POST['tipo']) && isset($_POST['descripcion']) && isset($_POST['dia_inicio']) && isset($_POST['dia_fin']) && isset($_POST['mes_inicio']) && isset($_POST['mes_fin']) && isset($_POST['estado'])) {

            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $tipo = $_POST['tipo'];
            $dia_inicio = $_POST['dia_inicio'];
            $dia_fin = $_POST['dia_fin'];
            $mes_inicio = $_POST['mes_inicio'];
            $mes_fin = $_POST['mes_fin'];
            $estado = $_POST['estado'];

            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $fecha_inicio = sprintf('%02d%02d', $mes_inicio, $dia_inicio);
            $fecha_fin = sprintf('%02d%02d', $mes_fin, $dia_fin);

            // $fecha_parts = explode('-', $fecha);
            // $mes = $fecha_parts[1];
            // $dia = $fecha_parts[2];
            $error_msg = '';
            if (empty($nombre) || empty($tipo) || empty($dia_inicio) || empty($mes_inicio) || empty($dia_fin) || empty($mes_fin)) {
                $error_msg .= 'Ingrese los datos Necesarios. <br>';
            }
            if ($fecha_inicio > $fecha_fin) {
                $error_msg .= 'La fecha de inicio no puede ser posterior a la fecha de fin. <br>';
            }
            if (!empty($descripcion)) {
                if (strlen($descripcion) <= 8 || strlen($descripcion) >= 50) {
                    $error_msg .= 'La descripcion debe de tener de tener almenos 8 caracteres. <br>';
                }
            }
            if ($estado != 'Activo' && $estado != 'Inactivo') {
                $error_msg .= 'Estado Incorrecto. <br>' . $estado;
            }

            if ($error_msg) {
                $respuesta = ['msg' => $error_msg, 'icono' => 'warning'];
            }
            // create
            if (!$id && empty($error_msg)) {
                $data = $this->model->create($dia_inicio, $mes_inicio, $dia_fin, $mes_fin, $nombre, $descripcion, $tipo);
                $respuesta = ['msg' => 'Evento Creado', 'icono' => 'success'];
            }
            // update
            if ($id && empty($error_msg)) {
                $data = $this->model->update($dia_inicio, $mes_inicio, $dia_fin, $mes_fin, $nombre, $descripcion, $tipo, $estado, $id);
                $respuesta = ['msg' => 'Calendario Actualizado', 'icono' => 'success'];
            }
        } else {
            $respuesta = ['msg' => 'Error Datos Incompletos', 'icono' => 'error'];
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
                $respuesta = ['msg' => 'se ha dado de baja', 'icono' => 'success'];
            } else {
                $respuesta = ['msg' => 'error al eliminar', 'icono' => 'error'];
            }
        } else {
            $respuesta = ['msg' => 'error desconocido', 'icono' => 'error'];
        }
        echo json_encode($respuesta);
        die();
    }
    //editar user
    public function edit($id)
    {
        if (is_numeric($id)) {
            $data = $this->model->buscar($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
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

    public function obtenerDatosPorRUC($dni)
    {
        if ((empty($dni)) || (!(strlen($dni) == 11))) {
            // Manejo del error si el DNI está vacío o no tiene la longitud esperada
        } else {
            $token = 'apis-token-8285.mKhIxulHCg46xmhD1LwgiS-jfiftQR6i';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/ruc?numero=' . $dni,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 2,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Referer: https://apis.net.pe/consulta-ruc-api',
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
