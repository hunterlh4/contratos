<?php
class Login extends Controller
{
    public function __construct()
    {
        parent::__construct();

        session_start();
    }
    public function index()
    {
        if (!empty($_SESSION['usuario_autenticado'])) {
            header('Location: ' . BASE_URL . 'admin/home');
            exit;
        }
        $data['title'] = 'Acceso al sistema';
        $this->views->getView('home', "Login", $data);
    }

    // public function validar2()
    // {
    //     $validar = "vacio";
    //     if (isset($_POST['username']) && isset($_POST['password'])) {
    //         if (empty($_POST['username']) || empty($_POST['password'])) {
    //             $respuesta = ['msg' => 'todo los campos son requeridos', 'icono' => 'warning');
    //         } else {
    //             $data = $this->model->getLogin(strtolower($_POST['username']));
    //             if (empty($data)) {
    //                 $respuesta = ['msg' => ' no existe', 'icono' => 'warning');
    //             } else {
    //                 if (password_verify(strtolower($_POST['password']), $data['password'])) {
    //                     $_SESSION['id'] = $data['id'];
    //                     $_SESSION['username'] = $data['username'];
    //                     $_SESSION['nombre'] = $data['nombre'];
    //                     $_SESSION['apellido']  = $data['apellido'];
    //                     $_SESSION['nivel']  = $data['nivel'];
    //                     $_SESSION['usuario_autenticado'] = "true";
    //                     $validar = $this->model->usuario_conectado($data['id']);
    //                     if (empty($validar)) {
    //                         $this->model->registrar_conectado($data['id']);
    //                     } else {
    //                         // $validar no está vacío (es true)
    //                         // Realiza otra acción
    //                         $this->model->modificar_conectado($data['id']);
    //                     }
    //                     $respuesta = ['msg' => 'datos correcto', 'icono' => 'success');
    //                 } else {
    //                     $respuesta = ['msg' => 'contraseña incorrecta', 'icono' => 'warning');
    //                 }
    //             }
    //         }
    //     } else {
    //         $respuesta = ['msg' => 'error desconocido', 'icono' => 'error');
    //     }
    //     echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    //     die();
    // }

    public function validar()
    {
        $tiempo_expiracion = 3600; // 1 hora
        $respuesta = ['msg' => 'Error desconocido.', 'icono' => 'error'];
        $max_intentos = 100; // Número máximo de intentos permitidos

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si 'intentos_login' está definido en la sesión, si no, inicializarlo en 0
        if (!isset($_SESSION['intentos_login'])) {
            $_SESSION['intentos_login'] = 0;
            $_SESSION['ultimo_intento'] = time();
        }

        $tiempo_expiracion = 3600; // 1 hora
        $max_intentos = 100; // Número máximo de intentos permitidos

        // Resetear intentos si ha pasado el tiempo de expiración
        if ($_SESSION['intentos_login'] > 0 && time() - $_SESSION['ultimo_intento'] > $tiempo_expiracion) {
            $_SESSION['intentos_login'] = 0;
            $_SESSION['ultimo_intento'] = time();
        }

        // Verificar si se ha alcanzado el límite de intentos
        if ($_SESSION['intentos_login'] >= $max_intentos) {
            echo json_encode(['msg' => 'Demasiados intentos fallidos. <br>Vuelve más tarde.', 'icono' => 'error'], JSON_UNESCAPED_UNICODE);
            die();
        }

        if (empty($_POST['username']) || empty($_POST['password'])) {
            echo json_encode(['msg' => 'Todos los campos son requeridos.', 'icono' => 'warning'], JSON_UNESCAPED_UNICODE);
            die();
        }

        $username = strtolower($_POST['username']);
        $password = strtolower($_POST['password']);
        $data = $this->model->getLogin($username);

        // Validar existencia del usuario
        if (empty($data)) {
            echo json_encode(['msg' => 'El usuario ingresado no existe.', 'icono' => 'warning'], JSON_UNESCAPED_UNICODE);
            die();
        }

        // Verificar contraseña
        if (!password_verify($password, $data['password'])) {
            $_SESSION['intentos_login']++;
            $_SESSION['ultimo_intento'] = time();
            $intentos_restantes = $max_intentos - $_SESSION['intentos_login'];
            echo json_encode(['msg' => 'Contraseña incorrecta. <br> Intentos restantes: ' . $intentos_restantes, 'icono' => 'warning'], JSON_UNESCAPED_UNICODE);
            die();
        }

        switch ($data['estado']) {
            case 1:
                $this->iniciarSesion($data);
                echo json_encode(['msg' => 'Datos correctos.', 'icono' => 'success'], JSON_UNESCAPED_UNICODE);
                break;
            case 0:
                echo json_encode(['msg' => 'Su cuenta ha sido <br>inhabilitada.', 'icono' => 'error'], JSON_UNESCAPED_UNICODE);
                break;
            case 2:
                echo json_encode(['msg' => 'Su cuenta está <br>pendiente de aprobación.', 'icono' => 'warning'], JSON_UNESCAPED_UNICODE);
                break;
        }



        // Si el contador de intentos ha alcanzado el máximo permitido
        // if ($_SESSION['intentos_login'] >= $max_intentos) {
        //     $respuesta = ['msg' => 'Demasiados intentos fallidos. <br>Vuelve más tarde.', 'icono' => 'error'];
        // } else {
        //     // Procesa el formulario de inicio de sesión
        //     $validar = "vacío";
        //     if (isset($_POST['username']) && isset($_POST['password'])) {
        //         if (empty($_POST['username']) || empty($_POST['password'])) {
        //             $respuesta = ['msg' => 'Todos los campos son requeridos.', 'icono' => 'warning'];
        //         } else {
        //             $data = $this->model->getLogin(strtolower($_POST['username']));
        //             if (empty($data)) {
        //                 $respuesta = ['msg' => 'El usuario ingresado no existe.', 'icono' => 'warning'];
        //             } else {
        //                 if (password_verify(strtolower($_POST['password']), $data['password'])) {
        //                     if ($data['estado'] == 'Activo') {

        //                         $rememberMe = isset($_POST['recuerdame']) && $_POST['recuerdame'] === 'true';

        //                         $_SESSION['id'] = $data['id'];
        //                         $_SESSION['username'] = $data['username'];
        //                         $_SESSION['nombre'] = $data['nombre'];
        //                         $_SESSION['apellido'] = $data['apellido'];
        //                         $_SESSION['nivel'] = $data['rol'];
        //                         $_SESSION['usuario_autenticado'] = true;

        //                         $direccionIp = $this->obtenerIpCliente();
        //                         $_SESSION['ip'] = $direccionIp;

        //                         if ($rememberMe) {
        //                             setcookie('id', $data['id'], time() + (86400 * 30), "/"); // 30 días
        //                             setcookie('username', $data['username'], time() + (86400 * 30), "/");
        //                             setcookie('nombre', $_SESSION['nombre'], time() + (86400 * 30), "/");
        //                             setcookie('apellido', $_SESSION['apellido'], time() + (86400 * 30), "/");
        //                             setcookie('nivel', $_SESSION['nivel'], time() + (86400 * 30), "/");
        //                             setcookie('ip', $_SESSION['ip'], time() + (86400 * 30), "/");
        //                             setcookie('usuario_autenticado', true, time() + (86400 * 30), "/");
        //                         } else {
        //                             setcookie('user_id', '', time() - 3600, "/"); // Elimina la cookie
        //                             setcookie('username', '', time() - 3600, "/");
        //                             setcookie('nombre', '', time() - 3600, "/");
        //                             setcookie('apellido', '', time() - 3600, "/");
        //                             setcookie('nivel', '', time() - 3600, "/");
        //                             setcookie('ip', '', time() - 3600, "/");
        //                             setcookie('usuario_autenticado', '', time() - 3600, "/");
        //                         }

        //                         $validar = $this->model->usuario_conectado($data['id']);

        //                         if (empty($validar)) {
        //                             $this->model->registrar_conectado($data['id']);
        //                         } else {
        //                             $this->model->modificar_conectado($data['id']);
        //                         }
        //                         $respuesta = ['msg' => 'Datos correctos.', 'icono' => 'success'];
        //                         $_SESSION['intentos_login'] = 0; // Reinicia el contador de intentos
        //                     } elseif ($data['estado'] == 'Inactivo') {
        //                         $respuesta = ['msg' => 'Su cuenta ha sido <br>inhabilitada.', 'icono' => 'error'];
        //                     } elseif ($data['estado'] == 'Pendiente') {
        //                         $respuesta = ['msg' => 'Su cuenta está <br>pendiente de aprobación.', 'icono' => 'warning'];
        //                     }
        //                 } else {
        //                     $_SESSION['intentos_login']++; // Incrementa el contador de intentos
        //                     $_SESSION['ultimo_intento'] = time(); // Actualiza la marca de tiempo del último intento
        //                     $intentos_restantes = $max_intentos - $_SESSION['intentos_login'];
        //                     $respuesta = ['msg' => 'Contraseña incorrecta. <br> Intentos restantes: ' . $intentos_restantes, 'icono' => 'warning'];
        //                 }
        //             }
        //         }
        //     } else {
        //         $respuesta = ['msg' => 'Error desconocido.', 'icono' => 'error'];
        //     }
        // }
        // echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        // die();
    }

    function obtenerIpCliente()
    {
        $ip = '';

        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Manejar el caso de múltiples direcciones IP en X_FORWARDED_FOR
            $ipLista = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim(end($ipLista));
        } elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }


    function iniciarSesion($data)
    {
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nombre'] = "a";
        // $_SESSION['apellido'] = $data['apellido'];
        $_SESSION['apellido'] = "b";
        $_SESSION['nivel'] = $data['rol_id'];
        $_SESSION['usuario_autenticado'] = true;
        $_SESSION['ip'] = $this->obtenerIpCliente();
        $_SESSION['intentos_login'] = 0; // Reiniciar intentos

        $this->manejarCookies($data);

        // $validar = $this->model->usuario_conectado($data['id']);
        // empty($validar) ? $this->model->registrar_conectado($data['id']) : $this->model->modificar_conectado($data['id']);
    }

    function manejarCookies($data)
    {
        $rememberMe = isset($_POST['recuerdame']) && $_POST['recuerdame'] === 'true';
        $tiempo = $rememberMe ? time() + (86400 * 30) : time() - 3600; // 30 días o eliminar
        $path = "/";

        $cookies = ['id', 'username', 'nombre', 'apellido', 'nivel', 'ip', 'usuario_autenticado'];
        foreach ($cookies as $cookie) {
            setcookie($cookie, $rememberMe ? $_SESSION[$cookie] : '', $tiempo, $path);
        }
    }
}
