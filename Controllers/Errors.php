<?php
class Errors extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Error 404';
        $this->views->getView('errors', "index",$data);
    }
}