<?php
class Views{
 
    public function getView($ruta, $vista, $data="",$data1="",$data2='')
    {
        if ($ruta == "home") {
            $vista = "Views/".$vista.".php";
        }else{
            $vista = "Views/".$ruta."/".$vista.".php";
        }
        require $vista;
    }
}
?>