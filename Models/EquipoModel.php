<?php
class EquipoModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getEquipos()
    {
        $sql = "SELECT id,nombre,estrategia,estado from Equipo ORDER BY id ASC";

        return $this->selectAll($sql);
    }
    public function getEquipo($id)
    {
        $sql = "SELECT * FROM Equipo WHERE id = $id";
        return $this->select($sql);
    }
    public function verificar($nombre)
    {
        $sql = "SELECT id,nombre FROM Equipo WHERE nombre = '$nombre' ";
        return $this->select($sql);
    }
    public function registrar($nombre, $estrategia)
    {
        $sql = "INSERT INTO Equipo (nombre,estrategia) VALUES (?,?)";
        $array = array($nombre,$estrategia);
        return $this->insertar($sql, $array);
    }
    public function modificar($nombre,$estrategia,$estado,$id)
    {
        $sql = "UPDATE Equipo SET nombre=?,estrategia=?,estado=?  ,update_at = NOW() WHERE id = ?";
        $array = array($nombre,$estrategia,$estado, $id);
        return $this->save($sql, $array);
    }
    public function eliminar($id)
    {
        $sql = "UPDATE Equipo SET estado = ? WHERE id = ?";
        $array = array(0, $id);
        return $this->save($sql, $array);
    }

    
    public function registrarlog($usuario,$accion,$tabla,$detalles){
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario,$accion,$tabla,$detalles);
        return $this->save($sql, $array);
    }
}
