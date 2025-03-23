<?php
class AsistenciaModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getasistencias()
    {
        $sql = "SELECT * from asistencia ORDER BY fecha asc ASC";

        return $this->selectAll($sql);
    }
    public function getAsistenciaPorFecha($id,$anio,$mes)
    {
        $sql = "SELECT
                a.trabajador_id AS tid,
    	        a.id AS aid,
                fecha,
                TO_CHAR(hd.total ::interval, 'HH24:MI') AS total_horario,
                TO_CHAR(entrada ::interval, 'HH24:MI') AS entrada,
                TO_CHAR(salida ::interval, 'HH24:MI') AS salida,
                TO_CHAR(total_reloj ::interval, 'HH24:MI') AS total_reloj,
                TO_CHAR(tardanza ::interval, 'HH24:MI') AS tardanza,
                tardanza_cantidad,
                TO_CHAR(reloj_1 ::interval, 'HH24:MI') AS reloj_1,
                TO_CHAR(reloj_2 ::interval, 'HH24:MI') AS reloj_2,
                TO_CHAR(reloj_3 ::interval, 'HH24:MI') AS reloj_3,
                TO_CHAR(reloj_4 ::interval, 'HH24:MI') AS reloj_4,
                TO_CHAR(reloj_5 ::interval, 'HH24:MI') AS reloj_5,
                TO_CHAR(reloj_6 ::interval, 'HH24:MI') AS reloj_6,
                TO_CHAR(reloj_7 ::interval, 'HH24:MI') AS reloj_7,
                TO_CHAR(reloj_8 ::interval, 'HH24:MI') AS reloj_8,
                licencia, 
                justificacion,
                EXTRACT(YEAR FROM fecha) AS anio,
                EXTRACT(MONTH FROM fecha) AS mes,
                EXTRACT(DAY FROM fecha) AS dia,
                EXTRACT(HOUR FROM entrada) AS hora_entrada,
                EXTRACT(MINUTE FROM entrada) AS minuto_entrada,
                EXTRACT(HOUR FROM salida) AS hora_salida,
                EXTRACT(MINUTE FROM salida) AS minuto_salida
        FROM asistencia AS a 
        INNER JOIN trabajador AS t ON t.id = a.trabajador_id 
        inner JOIN horariodetalle AS hd ON t.horariodetalle_id = hd.id 
        WHERE trabajador_id = $id
        AND EXTRACT(YEAR FROM fecha) = $anio
        ORDER BY fecha asc";

      
        return $this->selectAll($sql);
    }

    public function getAllAsistenciasTrabajador($id,$anio){
        $sql= "SELECT fecha,
        TO_CHAR(entrada ::interval, 'HH24:MI') AS entrada,
        TO_CHAR(salida ::interval, 'HH24:MI') AS salida,
        
        licencia,tardanza_cantidad 
        FROM asistencia
        WHERE trabajador_id = $id
        AND EXTRACT(YEAR FROM fecha) = $anio 
        -- AND EXTRACT(MONTH FROM fecha) = 5

         ORDER BY fecha desc";
          return $this->selectAll($sql);
    }
    public function verificar($nombre)
    {
        $sql = "SELECT id,nombre FROM asistencia WHERE nombre = '$nombre' ";
        return $this->select($sql);
    }

    public function getusuario($id){
        $sql = "SELECT trabajador_id,t.apellido_nombre
                FROM usuario as u
                inner join trabajador as t on t.id=u.trabajador_id 
                WHERE u.id = $id";
        return $this->select($sql);
    }
    public function registrar($nombre, $nivel)
    {
        $sql = "INSERT INTO asistencia (nombre,nivel) VALUES (?,?)";
        $array = array($nombre,$nivel);
        return $this->insertar($sql, $array);
    }
    public function modificar($nombre,$nivel,$estado,$id)
    {
        $sql = "UPDATE asistencia SET nombre=?,nivel=?,estado=? ,update_at = NOW()  WHERE id = ?";
        $array = array($nombre,$nivel,$estado, $id);
        return $this->save($sql, $array);
    }

    public function modificarJustificacion($justificacion,$id)
    {
        $sql = "UPDATE asistencia SET justificacion=? ,update_at = NOW()  WHERE id = ?";
        $array = array($justificacion, $id);
        return $this->save($sql, $array);
    }
    public function edit($id)
    {
        $sql = "SELECT   id ,
        trabajador_id,
        fecha,
        TO_CHAR(total ::interval, 'HH24:MI') AS total,
        TO_CHAR(entrada ::interval, 'HH24:MI') AS entrada,
        TO_CHAR(salida ::interval, 'HH24:MI') AS salida,
        TO_CHAR(total_reloj ::interval, 'HH24:MI') AS total_reloj,
        TO_CHAR(tardanza ::interval, 'HH24:MI') AS tardanza,
        tardanza_cantidad,
        TO_CHAR(reloj_1 ::interval, 'HH24:MI') AS reloj_1,
        TO_CHAR(reloj_2 ::interval, 'HH24:MI') AS reloj_2,
        TO_CHAR(reloj_3 ::interval, 'HH24:MI') AS reloj_3,
        TO_CHAR(reloj_4 ::interval, 'HH24:MI') AS reloj_4,
        TO_CHAR(reloj_5 ::interval, 'HH24:MI') AS reloj_5,
        TO_CHAR(reloj_6 ::interval, 'HH24:MI') AS reloj_6,
        TO_CHAR(reloj_7 ::interval, 'HH24:MI') AS reloj_7,
        TO_CHAR(reloj_8 ::interval, 'HH24:MI') AS reloj_8,
        licencia, 
        justificacion FROM asistencia  WHERE id = $id";
        
        return $this->select($sql);
    }

    
    public function registrarlog($usuario,$accion,$tabla,$detalles){
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario,$accion,$tabla,$detalles);
        return $this->save($sql, $array);
    }
}
