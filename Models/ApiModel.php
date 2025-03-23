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
}