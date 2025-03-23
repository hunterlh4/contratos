<?php
class HorarioModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getHorarios()
    {
        $sql = "SELECT id,nombre,comentario,estado from Horario ORDER BY id ASC";

        return $this->selectAll($sql);
    }
    public function getHorario($id)
    {
        $sql = "SELECT * FROM Horario WHERE id = $id";
        return $this->select($sql);
    }
    public function verificar($nombre)
    {
        $sql = "SELECT id,nombre FROM Horario WHERE nombre = '$nombre' ";
        return $this->select($sql);
    }
    public function registrar($nombre, $comentario)
    {
        $sql = "INSERT INTO Horario (nombre,comentario) VALUES (?,?)";
        $array = array($nombre,$comentario);
        return $this->insertar($sql, $array);
    }
    public function modificar($nombre,$comentario,$estado,$id)
    {
        $sql = "UPDATE Horario SET nombre=?,comentario=?,estado=? ,update_at = NOW()  WHERE id = ?";
        $array = array($nombre,$comentario,$estado, $id);
        return $this->save($sql, $array);
    }
    public function eliminar($id)
    {
        $sql = "UPDATE Horario SET estado = ? WHERE id = ?";
        $array = array(0, $id);
        return $this->save($sql, $array);
    }
    public function registrarlog($usuario,$accion,$tabla,$detalles){
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario,$accion,$tabla,$detalles);
        return $this->save($sql, $array);
    }
}
