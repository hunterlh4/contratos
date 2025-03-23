<?php
class Home extends Controller
{
    public function __construct() {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['perfil'] = 'no';
        $data['TITLE'] = 'Pagina Principal';
        $this->views->getView('home', "index", $data);
    }
}