<?php
class Configuracion extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin/home');
            exit;
        }
        if($_SESSION['nivel'] !==1 &&  $_SESSION['nivel'] !==100){
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
    }
    public function index()
    {
       
       
        $data['title'] = 'Configuracion';
        $data1 = '';
        $this->views->getView('Administracion', "Configuracion", $data, $data1);
    }
    public function getConfiguracion()
    {
        $data = $this->model->getConfiguracion(1);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);

        die();
    }

    public function actualizar()
    {
        if (isset($_POST['api_1']) && isset($_POST['api_2']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $api_1 =  $_POST['api_1'];
            $api_2 =  $_POST['api_2'];

            // $data= $this->model->modificar($api_1,$api_2);
            if (empty($id)) {

                $data = $this->model->registrar($api_1, $api_2);
                if ($data > 0) {
                    $respuesta = array('msg' => 'Datos registrados', 'icono' => 'success');
                } else {
                    $respuesta = array('msg' => 'Error al registrar', 'icono' => 'success');
                }
            } else {
                $data = $this->model->modificar($api_1, $api_2, $id);
                if ($data > 0) {
                    $respuesta = array('msg' => 'Datos Actualizados', 'icono' => 'success');
                } else {
                    $respuesta = array('msg' => 'Error al ActualizaR', 'icono' => 'success');
                }
            }
        } else {
            $respuesta = array('msg' => 'Ingrese la API', 'icono' => 'error');
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
}
