<?php
class ApiModel extends Query
{

    public function obtenerTrabajadores()
    {
        $sql = "SELECT  id,apellido_nombre,dni,estado from trabajador 
        
        order by apellido_nombre asc ";
        return $this->selectAll($sql);
    }

    public function obtenerTrabajadoresActivos()
    {
        $sql = "SELECT  id,apellido_nombre,dni,estado from trabajador 
        where estado = 'Activo' 
        order by apellido_nombre asc ";
        return $this->selectAll($sql);
    }

    public function listarDepartamento()
    {
        $sql = "SELECT  * from departamento 
       
        order by nombre asc ";
        return $this->selectAll($sql);
    }

    public function listarProvincia($departamento_id)
    {
        $sql = "SELECT  * from provincia where  departamento_id =$departamento_id  
       
        order by nombre asc ";
        return $this->selectAll($sql);
    }

    public function listarDistrito($provincia_id)
    {
        $sql = "SELECT  * from distrito where provincia_id = $provincia_id 
       
        order by nombre asc ";
        return $this->selectAll($sql);
    }
}
