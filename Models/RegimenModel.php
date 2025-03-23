<?php
class RegimenModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getRegimenes()
    {
        $sql = "SELECT id,nombre,sueldo,estado from regimen  ORDER BY id  ";

        return $this->selectAll($sql);
    }
    public function getregimen($id)
    {
        $sql = "SELECT id,nombre,sueldo,estado FROM regimen WHERE id = $id";
        return $this->select($sql);
    }
    public function verificar($nombre)
    {
        $sql = "SELECT id,nombre FROM regimen WHERE nombre = '$nombre' ";
        return $this->select($sql);
    }
    public function registrar($nombre, $sueldo)
    {
        $sql = "INSERT INTO regimen (nombre,sueldo) VALUES (?,?)";
        $array = array($nombre,$sueldo);
        return $this->insertar($sql, $array);
    }
    public function modificar($nombre,$sueldo,$estado,$id)
    {
        $sql = "UPDATE regimen SET nombre=?,sueldo=?,estado=? ,update_at = NOW()  WHERE id = ?";
        $array = array($nombre,$sueldo,$estado, $id);
        return $this->save($sql, $array);
    }
    public function eliminar($id)
    {
        $sql = "UPDATE regimen SET estado = ? WHERE id = ?";
        $array = array(0, $id);
        return $this->save($sql, $array);
    }

    
    public function registrarlog($usuario,$accion,$tabla,$detalles){
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario,$accion,$tabla,$detalles);
        return $this->save($sql, $array);
    }
}
