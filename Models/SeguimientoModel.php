<?php
class SeguimientoModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getSeguimientos()
    {
        // $sql = "SELECT * from horario_detalle ORDER BY id ASC";
        // $sql = "SELECT * FROM horario_detalle WHERE horario_id = $id";

        $sql = "SELECT * FROM seguimientoTrabajador ORDER BY id asc ";
        // $sql = "SELECT T.id as tid,T.estado as testado from trabajadores as T ORDER BY id ASC";
        return $this->selectAll($sql);
    }
    public function getSeguimientoPorTrabajador($id)
    {
        $sql = "SELECT * FROM seguimientoTrabajador WHERE trabajador_id = $id order by id ;";

        return $this->selectAll($sql);
    }
    public function getSeguimiento($id){
        $sql = "SELECT * FROM seguimientoTrabajador WHERE id = $id";
       
        return $this->select($sql);
    }
    public function getDireccion()
    {
        $sql = "SELECT 
        d.id as did,
        d.nombre as dnombre,
        e.nombre as enombre ,
        d.estado as destado,
        e.estado as eestado 
        FROM direccion as d LEFT JOIN equipo as e on d.equipo_id = e.id order by d.nombre";
        return $this->selectAll($sql);
    }

    public function getHorario()
    {
        $sql = "SELECT * FROM horario";
        return $this->selectAll($sql);
    }

    public function getRegimen()
    {
        $sql = "SELECT * FROM regimen";
        return $this->selectAll($sql);
    }

    public function getCargo()
    {
        $sql = "SELECT * FROM cargo";
        return $this->selectAll($sql);
    }
    public function verificar($id)
    {
        $sql = "SELECT id,documento FROM seguimientotrabajador WHERE id = '$id' ";
        return $this->select($sql);
    }
    public function registrar($trabajador_id,$regimen,$direccion, $cargo,$documento,$sueldo,$fecha_inicio,$fecha_fin)
    {
        $sql = "INSERT INTO seguimientoTrabajador (trabajador_id, regimen, direccion, cargo, documento, sueldo, fecha_inicio, fecha_fin) VALUES (?,?,?,?,?,?,?,?)";
        $array = array($trabajador_id,$regimen,$direccion, $cargo,$documento,$sueldo,$fecha_inicio,$fecha_fin);
        return $this->insertar($sql, $array);
    }
    public function modificar($trabajador_id,$regimen,$direccion, $cargo,$documento,$sueldo,$fecha_inicio,$fecha_fin,$estado,$id)
    {
        $sql = "UPDATE seguimientoTrabajador SET trabajador_id=?,regimen=?,direccion=?,cargo=?,documento=?,sueldo=?,fecha_inicio=?,fecha_fin=?,estado=? ,update_at = NOW()  WHERE id = ?";
        $array = array($trabajador_id,$regimen,$direccion, $cargo,$documento,$sueldo,$fecha_inicio,$fecha_fin,$estado, $id);
        return $this->save($sql, $array);
    }
    public function modificarSinArchivo($trabajador_id,$regimen,$direccion, $cargo,$sueldo,$fecha_inicio,$fecha_fin,$estado,$id)
    {
        $sql = "UPDATE seguimientoTrabajador SET trabajador_id=?,regimen=?,direccion=?,cargo=?,sueldo=?,fecha_inicio=?,fecha_fin=?,estado=? ,update_at = NOW()  WHERE id = ?";
        $array = array($trabajador_id,$regimen,$direccion, $cargo,$sueldo,$fecha_inicio,$fecha_fin,$estado, $id);
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
