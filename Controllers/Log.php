<?php
class Log extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: '. BASE_URL . 'admin/home');
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
        $this->views->getView('Administracion', "Log", $data,$data1);
        
    }
    public function getLogs()
    {
        $data = $this->model->getLogs();

        for ($i = 0; $i < count($data); $i++) {
           


            $fecha = $data[$i]['fecha'];


            $fecha = date('d-m-Y H:i:s', strtotime($fecha));
            $data[$i]['fecha']= $fecha;

            
            
            $data[$i]['accion'] = '<div class="d-flex">
                <button class="btn btn-info" type="button" onclick="view(' . $data[$i]['log_id'] . ')"><i class="fas fa-eye"></i></button>
                </div>';
            
           
            // <button class="btn btn-danger" type="button" onclick="ViewUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // <button class="btn btn-danger" type="button" onclick="DeleteUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // colocar eliminar si es necesario
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
     
        die();
    }

    public function view($id)
    {
        $data = $this->model->getlog($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
     
        die();
    }

   

    
    
}