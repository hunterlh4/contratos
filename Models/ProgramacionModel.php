<?php
class ProgramacionModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function findAll()
    {
        $sql = "SELECT * 
        FROM festividad";
        return $this->selectAll($sql);
    }

    public function findOneById($id)
    {
        $sql = "SELECT * from festividad where id = $id";
        return $this->select($sql);
    }

    public function findOneByDate($dia,$mes)
    {
        $sql = "SELECT * FROM festividad WHERE dia = '$dia' and mes = '$mes' ";
        return $this->select($sql);
    }

    public function create($dia_inicio, $mes_inicio,$dia_fin,$mes_fin, $nombre, $descripcion, $tipo)
    {
        $sql = "INSERT INTO festividad (dia_inicio,mes_inicio,dia_fin,mes_fin,nombre,descripcion,tipo) VALUES (?,?,?,?,?,?,?)";
        $array = array($dia_inicio, $mes_inicio,$dia_fin,$mes_fin, $nombre, $descripcion, $tipo);
        return $this->insertar($sql, $array);
    }
    public function update($dia_inicio, $mes_inicio,$dia_fin,$mes_fin, $nombre, $descripcion, $tipo, $estado, $id)
    {
        $sql = "UPDATE festividad SET dia_inicio=?,mes_inicio = ?,dia_fin=?,mes_fin=?,nombre=?,descripcion=?,tipo=?,estado=?, update_at=NOW()  WHERE id = ?";
        $array = array($dia_inicio, $mes_inicio,$dia_fin,$mes_fin, $nombre, $descripcion, $tipo, $estado, $id);
        return $this->save($sql, $array);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM festividad where id='$id'";
        return $this->eliminar($sql);
    }
    public function createLog($usuario, $accion, $tabla, $detalles)
    {
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario, $accion, $tabla, $detalles);
        return $this->save($sql, $array);
    }
}
