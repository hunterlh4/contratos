<?php
class HoraExtraModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listar($trabajador_id, $today)
    {
        // $sql = "SELECT * FROM horas_extra WHERE trabajador_id = '$trabajador_id' AND '$today' <= fecha_hasta AND estado ='Activo'"; 
        // $sql = "SELECT id,tipo,trabajador_id,fecha_desde,fecha_hasta,hora_desde,hora_hasta,dia_completo,estado,
        // TO_CHAR(diferencia ::interval, 'HH24:MI') AS diferencia FROM horas_extra WHERE trabajador_id = 812 and NOW() <= fecha_hasta AND estado ='Activo'";

        $sql = "SELECT 
                    id,
                    tipo,
                    trabajador_id,
                    fecha_desde,
                    fecha_hasta,
                    hora_desde,
                    hora_hasta,
                    dia_completo,
                    estado,
                    TO_CHAR(diferencia ::interval, 'HH24:MI') AS diferencia,
                    'aumentar' AS tipo_consulta
                FROM 
                    horas_extra 
                WHERE 
                    trabajador_id = '$trabajador_id'
                    AND '$today' <= fecha_hasta 
                    AND estado = 'Activo' 
                    AND tipo = 'aumentar' 

                UNION ALL

                -- Consultar registros para tipo 'restar' y 'usado' con fecha_desde <= NOW()
                SELECT 
                    id,
                    tipo,
                    trabajador_id,
                    fecha_desde,
                    fecha_hasta,
                    hora_desde,
                    hora_hasta,
                    dia_completo,
                    estado,
                    TO_CHAR(diferencia ::interval, 'HH24:MI') AS diferencia,
                    'restar' AS tipo_consulta
                FROM 
                    horas_extra 
                WHERE 
                    trabajador_id = '$trabajador_id' 
                    AND estado = 'Activo' 
                    AND '$today' <= fecha_desde 
                    AND tipo IN ('restar', 'usado') 

                UNION ALL

                -- Consultar registros con fecha_hasta anteriores a NOW()
                SELECT 
                    id,
                    tipo,
                    trabajador_id,
                    fecha_desde,
                    fecha_hasta,
                    hora_desde,
                    hora_hasta,
                    dia_completo,
                    estado,
                    TO_CHAR(diferencia ::interval, 'HH24:MI') AS diferencia,
                    'usado' AS tipo_consulta
                FROM 
                    horas_extra 
                WHERE 
                    trabajador_id = '$trabajador_id' 
                    AND '$today' > fecha_hasta 
                    AND estado = 'Activo'";
        return $this->selectAll($sql);
    }

    public function calcularHoras($trabajador_id, $today)
    {
        $sql = "WITH min_max_dates AS (
                    SELECT 
                        MIN(fecha_desde) AS min_fecha_desde,
                        MAX(fecha_hasta) AS max_fecha_hasta
                    FROM 
                        horas_extra 
                    WHERE 
                        trabajador_id = '$trabajador_id' 
                        AND '$today' <= fecha_hasta 
                        AND estado = 'Activo' 
                        AND tipo = 'aumentar'
                ),
                horas_aumentar AS (
                    SELECT 
                        SUM(diferencia::interval) AS total_aumentar
                    FROM 
                        horas_extra 
                    WHERE 
                        trabajador_id = '$trabajador_id' 
                        AND '$today' <= fecha_hasta 
                        AND estado = 'Activo' 
                        AND tipo = 'aumentar'
                ),
                horas_restar AS (
                    SELECT 
                        SUM(diferencia::interval) AS total_restar
                    FROM 
                        horas_extra 
                    WHERE 
                        trabajador_id = '$trabajador_id' 
                        AND estado = 'Activo' 
                        AND tipo = 'restar'
                        AND fecha_desde BETWEEN (SELECT min_fecha_desde FROM min_max_dates) AND (SELECT max_fecha_hasta FROM min_max_dates)
                )
                        SELECT
                    TO_CHAR((total_aumentar - COALESCE(total_restar, '00:00:00'::interval)), 'HH24:MI') AS horas_extra_disponibles,
                    (SELECT min_fecha_desde FROM min_max_dates) AS min_fecha_desde,
                    (SELECT max_fecha_hasta FROM min_max_dates) AS max_fecha_hasta
                FROM
                    horas_aumentar, horas_restar";
        return $this->select($sql);
    }


    public function agregar($tipo, $trabajador_id, $fecha_desde, $fecha_hasta, $hora_desde, $hora_hasta, $diferencia, $dia_completo)
    {
        $sql = "INSERT INTO horas_extra (tipo,trabajador_id,fecha_desde,fecha_hasta,hora_desde,hora_hasta,diferencia,dia_completo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $array = array($tipo, $trabajador_id, $fecha_desde, $fecha_hasta, $hora_desde, $hora_hasta, $diferencia, $dia_completo);
        return $this->insertar($sql, $array);
    }
    public function editar($tipo, $trabajador_id, $fecha_desde, $fecha_hasta, $hora_desde, $hora_hasta, $diferencia, $dia_completo, $estado, $id)
    {
        $sql = "UPDATE horas_extra SET tipo=?,trabajador_id = ?,fecha_desde=?,fecha_hasta=?,hora_desde=?,hora_hasta=?,diferencia=?,dia_completo=?,estado=?, update_at=NOW()  WHERE id = ?";
        $array = array($tipo, $trabajador_id, $fecha_desde, $fecha_hasta, $hora_desde, $hora_hasta, $diferencia, $dia_completo, $estado, $id);
        return $this->save($sql, $array);
    }
    public function buscar($id)
    {
        $sql = "SELECT id, tipo,trabajador_id,fecha_desde,fecha_hasta,estado,
                TO_CHAR(hora_desde, 'HH24:MI') AS hora_desde,
                TO_CHAR(hora_hasta, 'HH24:MI') AS hora_hasta, 
                TO_CHAR(diferencia, 'HH24:MI') AS diferencia
                FROM horas_extra WHERE id= '$id'";
        return $this->select($sql);
    }
    public function listarTotal($trabajador_id, $today)
    {
        $sql = "SELECT 
                TO_CHAR(SUM(diferencia), 'HH24:MI') AS total_diferencia,
                'aumentar' AS tipo_consulta
                FROM 
                    horas_extra 
                WHERE 
                    trabajador_id = '$trabajador_id'
                    AND '$today' <= fecha_hasta 
                    AND estado = 'Activo' 
                    AND tipo = 'aumentar';";
        return $this->select($sql);
    }

    public function createLog($usuario, $accion, $tabla, $detalles)
    {
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario, $accion, $tabla, $detalles);
        return $this->save($sql, $array);
    }
}
