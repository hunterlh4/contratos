<?php
class HorarioDetalleModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getHorarioDetalles()
    {
        // $sql = "SELECT * from horarioDetalle ORDER BY id ASC";
        // $sql = "SELECT * FROM horarioDetalle WHERE horario_id = $id";
        $sql = "SELECT 
        id, 
        nombre, 
        TO_CHAR(hora_entrada, 'HH24:MI') AS nueva_entrada,
        TO_CHAR(hora_salida, 'HH24:MI') AS nueva_salida,
        TO_CHAR(total, 'HH24:MI') AS total,
        estado
    FROM                
        horarioDetalle ORDER BY id ASC";
        return $this->selectAll($sql);
    }
    public function getHorarioDetallesPorHorario($id)
    {
        // $sql = "SELECT * FROM horarioDetalle WHERE horario_id = $id";

        $sql = "SELECT 
        id, 
        nombre, 
        TO_CHAR(hora_entrada, 'HH24:MI') AS nueva_entrada,
        TO_CHAR(hora_salida, 'HH24:MI') AS nueva_salida,
        TO_CHAR(total, 'HH24:MI') AS total,
        estado
    FROM 
        horarioDetalle
         WHERE horario_id = $id order by id asc";

        return $this->selectAll($sql);
    }
    public function getHorarioDetalle($id)
    {
        $sql = "SELECT * FROM horarioDetalle WHERE id = $id";
        return $this->select($sql);
    }
    // public function verificar($nombre)
    // {
    //     $sql = "SELECT id,nombre FROM horarioDetalle WHERE nombre = '$nombre' ";
    //     return $this->select($sql);
    // }
    public function registrar($nombre, $horario_id,$hora_entrada,$hora_salida,$total)
    {
        $sql = "INSERT INTO horarioDetalle (nombre,horario_id,hora_entrada,hora_salida,total) VALUES (?,?,?,?,?)";
        $array = array($nombre,$horario_id,$hora_entrada,$hora_salida,$total);
        return $this->insertar($sql, $array);
    }
    public function modificar($nombre, $horario_id,$hora_entrada,$hora_salida,$total,$estado,$id)
    {
        $sql = "UPDATE horarioDetalle SET nombre=?,horario_id=?,hora_entrada=?,hora_salida=?,total=?,estado=? ,update_at = NOW() WHERE id = ?";
        $array = array($nombre,$horario_id,$hora_entrada,$hora_salida,$total,$estado, $id);
        return $this->save($sql, $array);
    }
    // public function eliminar($id)
    // {
    //     $sql = "UPDATE HorarioDetalle SET estado = ? WHERE id = ?";
    //     $array = array(0, $id);
    //     return $this->save($sql, $array);
    // }
    public function registrarlog($usuario,$accion,$tabla,$detalles){
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario,$accion,$tabla,$detalles);
        return $this->save($sql, $array);
    }
}
