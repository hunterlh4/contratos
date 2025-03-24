<?php
class Api extends Controller
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
    public function listartrabajadores()
    {
        $data1 = $this->model->obtenerTrabajadores();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarTrabajadoresActivos()
    {

        $data = $this->model->obtenerTrabajadoresActivos();

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
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
        // echo $ip;
        return $ip;
    }


    function listarDepartamento()
    {

        $data1 = $this->model->listarDepartamento();

        echo json_encode($data1, JSON_UNESCAPED_UNICODE);
        die();
    }

    function listarProvincia()
    {
        if (isset($_POST['departamento_id'])) {

            $departamento_id = $_POST['departamento_id'];


            $data = $this->model->listarProvincia($departamento_id);


            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {

            $respuesta = ['msg' => 'error', 'icono' => 'error'];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        }

        // Detiene la ejecución del script
        die();
    }

    function listarDistrito()
    {
        if (isset($_POST['provincia_id'])) {

            $provincia_id = $_POST['provincia_id'];


            $data = $this->model->listarDistrito($provincia_id);


            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {

            $respuesta = ['msg' => 'error', 'icono' => 'error'];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        }

        // Detiene la ejecución del script
        die();
    }
}
