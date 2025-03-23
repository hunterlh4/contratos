<?php
class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        // if (!empty($_SESSION['usuario_autenticado'])) {
        //     header('Location: ' . BASE_URL . 'admin/home');
        //     exit;
        // }
        // $data['title'] = 'Acceso al sistema';
        // $this->views->getView('home', "login", $data);
        if (empty($_SESSION['usuario_autenticado'])) {
            header('Location: ' . BASE_URL . 'Login');
            exit;
        }
        
        $data['title'] = 'Administracion';
        // $data['title'] = $_SESSION['nivel'];
        $data['id'] =  $_SESSION['id'];
        $data['nivel'] =  $_SESSION['nivel'];
        $data['nombre'] =  $_SESSION['nombre'];
        $data['apellido'] =  $_SESSION['apellido'];
        $data1 = "";

        $this->views->getView('Administracion', "Index", $data, $data1);
    }

   
   
    public function perfil()
    {
        if (empty($_SESSION['usuario_autenticado'])) {
            header('Location: ' . BASE_URL . 'Login');
            exit;
        }


        $data = $this->model->getUsuarioId($_SESSION['id']);
        $data['id'] =  $_SESSION['id'];
        $data['title'] = 'Perfil';


        $data1 = "";
        // $data = $this->model->productosMinimos();
        // $data['pendientes'] = $this->model->getTotales(1);
        // $data['procesos'] = $this->model->getTotales(2);
        // $data['finalizados'] = $this->model->getTotales(3);
        // $data['productos'] = $this->model->getProductos();
        $this->views->getView('Administracion', "Profile", $data, $data1);
    }

    // public function mensajes()
    // {
    //     if (empty($_SESSION['nombre'])) {
    //         header('Location: ' . BASE_URL . 'admin');
    //         exit;
    //     }
    //     $data['title'] = 'mensajes';
    //     $data['id'] =  $_SESSION['id'];

    //     $data1 = "";
    //     // $data = $this->model->productosMinimos();
    //     // $data['pendientes'] = $this->model->getTotales(1);
    //     // $data['procesos'] = $this->model->getTotales(2);
    //     // $data['finalizados'] = $this->model->getTotales(3);
    //     // $data['productos'] = $this->model->getProductos();
    //     $this->views->getView('Administracion', "Mensaje", $data, $data1);
    // }
    public function home()
    {
        if (empty($_SESSION['usuario_autenticado'])) {
            header('Location: ' . BASE_URL . 'Login');
            exit;
        }
        
        $data['title'] = 'Administracion';
        // $data['title'] = $_SESSION['nivel'];
        $data['id'] =  $_SESSION['id'];
        $data['nivel'] =  $_SESSION['nivel'];
        $data['nombre'] =  $_SESSION['nombre'];
        $data['apellido'] =  $_SESSION['apellido'];
        $data1 = "";

        $this->views->getView('Administracion', "Index", $data, $data1);
    }

    public function actualizar()
    {
        if (isset($_POST['new_pass_1']) && isset($_POST['new_pass_2'])) {
            if (empty($_POST['new_pass_1']) || empty($_POST['new_pass_2'])) {
                $respuesta = array('msg' => 'todo los campos son requeridos', 'icono' => 'warning');
            } else {
                $data = $this->model->getUsuarioIdclave($_SESSION['id']);
                $this->model->usuario_actualizar($data['id'], $_POST['new_pass_1']);

                $respuesta = array('msg' => 'datos actualizados', 'icono' => 'success');
            }
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function mensaje(){
        if (empty($_SESSION['usuario_autenticado'])) {
            header('Location: ' . BASE_URL . 'Login');
            exit;
        }
        $data['title'] = 'Mensajeria';
       
        $data1 = "";
        $this->views->getView('Administracion', "Index", $data, $data1);
    }
    function conectado()
    {
        $validar = $this->model->usuario_conectado($_SESSION['id']);
        if (empty($validar)) {
            $this->model->modificar_conectado($validar);
        } else {
            $this->model->registrar_conectado($validar);
        }
        die();
    }
    public function salir()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }

    public function notificacion(){
        $total = $this->model->NotificacionTotal();
        $notificaciones = $this->model->Notificaciones();
    
        $data = [
            'total' => $total,
            'notificaciones' => $notificaciones
        ];
    
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
