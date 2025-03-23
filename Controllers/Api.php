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

    public function listarTrabajadoresActivos(){
        
        $data = $this->model->obtenerTrabajadoresActivos();

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    function obtenerIpCliente() {
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
}


