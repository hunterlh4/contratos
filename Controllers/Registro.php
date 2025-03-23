<?php
class Registro extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {

        $data['title'] = 'Registrar Usuario';
        $this->views->getView('home', "Registro", $data);
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
    public function listarDireccion()
    {
        $data1 = $this->model->getDireccion();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $dni = $_POST['dni'] ?? '';
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password-confirm'] ?? '';
            $direccion = $_POST['direccion'] ?? '';

            $error_message = '';

            // Validación del DNI
            if (!preg_match('/^\d{8}$/', $dni)) {
                $error_message .= "El <b>DNI</b> debe tener exactamente 8 dígitos.<br>";
            }

            // Validación de la fecha de nacimiento
            // Puedes ajustar la validación según tus necesidades
            if (empty($fecha_nacimiento)) {
                $error_message .= "La <b>fecha de nacimiento</b> es obligatoria.<br>";
            }

            // Validación del nombre y apellido
            if (!preg_match('/^[A-Z\s]{3,30}$/', $nombre)) {
                $error_message .= "El <b>nombre</b> debe tener entre 3 y 30 caracteres.<br>";
            }
            if (!preg_match('/^[A-Z\s]{5,30}$/', $apellido)) {
                $error_message .= "El <b>apellido</b> debe tener entre 5 y 30 caracteres.<br>";
            }

            // Validación del usuario
            if (!preg_match('/^[a-zA-Z0-9]{5,16}$/', $usuario)) {
                $error_message .= "El <b>usuario<b> debe tener entre 5 y 16 caracteres.<br>";
            }

            // Validación de la contraseña
            if (strlen($password) < 6 || strlen($password) > 20) {
                $error_message .= "La <b>contraseña</b> debe tener entre 6 y 20 caracteres.<br>";
            }
            if ($password !== $password_confirm) {
                $error_message .= "Las contraseñas no coinciden.<br>";
            }

            // Validación de la dirección
            if (empty($direccion)) {
                $error_message .= "Debes seleccionar una dirección.<br>";
            }
            $buscar_usuario = $this->model->validarUsuario($usuario);
            if (!empty($buscar_usuario)) {
                $error_message .= "El <b>usuario</b> ya está en uso.<br>";
            }
            // Si hay errores, devolver la respuesta con los errores
            if (!empty($error_message )) {
                echo json_encode(["icono" => "error", "titulo" => "Errores en el formulario:", "message" => $error_message ]);
                exit;
            }
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            
            $resultado = $this->model->registrar($dni, $fecha_nacimiento, $nombre,$apellido, $usuario, $password_hash, $direccion);
            // $data = $this->model->obtenerUsuario($usuario);
            // $mensaje = "pendiente de aprobación.";
            // $this->model->mensajeria($data['id'],$mensaje);
            if ($resultado > 0) {
                echo json_encode(["icono" => "success", "message" => "Registro exitoso"]);
            } else {
                echo json_encode(["icono" => "error", "message" => "Ocurrió un error al registrar el usuario."]);
            }
            exit;
        }


        echo json_encode(["icono" => "error", "titulo" => "Método no permitido"]);
        exit;
    }
}
