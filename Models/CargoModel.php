<?php
class CargoModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getCargos()
    {
        $sql = "SELECT id,nombre,nivel,estado from cargo ORDER BY id ASC";

        return $this->selectAll($sql);
    }
    public function getCargo($id)
    {
        $sql = "SELECT * FROM cargo WHERE id = $id";
        return $this->select($sql);
    }
    public function verificar($nombre)
    {
        $sql = "SELECT id,nombre FROM cargo WHERE nombre = '$nombre' ";
        return $this->select($sql);
    }
    public function registrar($nombre, $nivel)
    {
        $sql = "INSERT INTO cargo (nombre,nivel) VALUES (?,?)";
        $array = array($nombre,$nivel);
        return $this->insertar($sql, $array);
    }
    public function modificar($nombre,$nivel,$estado,$id)
    {
        $sql = "UPDATE cargo SET nombre=?,nivel=?,estado=? ,update_at = NOW()  WHERE id = ?";
        $array = array($nombre,$nivel,$estado, $id);
        return $this->save($sql, $array);
    }
    public function eliminar($id)
    {
        $sql = "UPDATE cargo SET estado = ? WHERE id = ?";
        $array = array(0, $id);
        return $this->save($sql, $array);
    }

    
    public function registrarlog($usuario,$accion,$tabla,$detalles){
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario,$accion,$tabla,$detalles);
        return $this->save($sql, $array);
    }
}
