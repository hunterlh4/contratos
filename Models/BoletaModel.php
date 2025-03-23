<?php
class BoletaModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getBoletas($parametro)
    {
        $sql = "SELECT b.id AS bid, numero,
                trabajador_id AS solicitanteid,
                t.apellido_nombre AS nombre_trabajador,
                aprobado_por AS aprobadorid, 
                t2.apellido_nombre AS nombre_aprobador,
                fecha_inicio,fecha_fin,hora_salida,hora_entrada,duracion,razon,razon_especifica,observaciones,estado_tramite,
                b.estado AS bestado ,
                tipo
                from boleta AS b 
                INNER JOIN trabajador AS t ON  t.id =b.trabajador_id 
                left JOIN trabajador AS t2 ON t2.id = b.aprobado_por
                where b.tipo ='$parametro'
                order by
                CASE 
                WHEN b.estado_tramite = 'Pendiente' THEN 1
                ELSE 2
                END,
                b.create_At desc";


        return $this->selectAll($sql);
    }

    public function getMisBoletas($id, $parametro)
    {
        $sql = "SELECT 

        t1.id AS trabajador_id,
        t1.apellido_nombre AS nombre_trabajador,
        t2.id AS aprobado_por,
        t2.apellido_nombre AS nombre_aprobador,
       
        b.id AS boleta_id,
        b.numero AS numero,
        b.fecha_inicio AS fecha_inicio,
        b.fecha_fin AS fecha_fin,
        b.hora_salida AS hora_salida,
        b.hora_entrada AS hora_entrada,
        b.razon AS razon,
        b.razon_especifica as razon_especifica,
        b.observaciones AS observaciones,
        b.estado_tramite AS estado_tramite,
        b.tipo as boleta_tipo
        FROM 
            boleta AS b
        LEFT JOIN 
            trabajador AS t1 ON b.trabajador_id = t1.id
        LEFT JOIN 
            trabajador AS t2 ON b.aprobado_por = t2.id
        inner JOIN
            cargo AS c ON c.id = t1.cargo_id
        
        WHERE b.trabajador_id = $id and
        b.tipo ='$parametro'
        order by b.create_At desc";

        return $this->selectAll($sql);
    }
    public function getusuario($id)
    {
        $sql = "SELECT trabajador_id,t.apellido_nombre
                FROM usuario as u
                inner join trabajador as t on t.id=u.trabajador_id 
                WHERE u.id = $id";
        return $this->select($sql);
    }

    public function getMisRevisiones($id, $parametro)
    {
        $sql = "SELECT 
        b.id ,
        t1.id AS trabajador_id,
        t1.apellido_nombre AS nombre_trabajador,
        t2.id AS aprobado_por,
        t2.apellido_nombre AS nombre_aprobador,
        b.id AS boleta_id,
        b.numero AS numero,
        b.fecha_inicio AS fecha_inicio,
        b.fecha_fin AS fecha_fin,
        b.hora_salida AS hora_salida,
        b.hora_entrada AS hora_entrada,
        b.razon AS razon,
        b.razon_especifica as razon_especifica,
        b.observaciones AS observaciones,
        b.estado_tramite AS estado_tramite,
        b.tipo as boleta_tipo
        FROM 
            boleta AS b
        LEFT JOIN 
            trabajador AS t1 ON b.trabajador_id = t1.id
        LEFT JOIN 
            trabajador AS t2 ON b.aprobado_por = t2.id
        inner JOIN
            cargo AS c ON c.id = t1.cargo_id
        WHERE aprobado_por = $id and
        b.tipo ='$parametro'
        order by
        CASE 
        WHEN b.estado_tramite = 'Pendiente' THEN 1
        -- WHEN b.estado_tramite = 'Aprobado' THEN 2
        ELSE 2
        END,
        b.create_At desc";
        return $this->selectAll($sql);
    }

    public function getBoletasPorteria()
    {
        $sql = "SELECT 
        b.id as bid,
        t1.id AS trabajador_id,
        t1.apellido_nombre AS nombre_trabajador,
        t2.id AS aprobado_por,
        t2.apellido_nombre AS nombre_aprobador,
        b.id AS boleta_id,
        b.numero AS numero,
        b.fecha_inicio AS fecha_inicio,
        b.fecha_fin AS fecha_fin,
        b.hora_salida AS hora_salida,
        b.hora_entrada AS hora_entrada,
        b.razon AS razon,
        b.razon_especifica as razon_especifica,
        b.observaciones AS observaciones,
        b.estado_tramite AS estado_tramite,
        b.tipo as boleta_tipo
        FROM 
            boleta AS b
        LEFT JOIN 
            trabajador AS t1 ON b.trabajador_id = t1.id
        LEFT JOIN 
            trabajador AS t2 ON b.aprobado_por = t2.id
        inner JOIN
            cargo AS c ON c.id = t1.cargo_id
        WHERE b.estado_tramite = 'Aprobado' AND
        b.tipo ='1'
        order by
        
        b.fecha_inicio DESC,
        hora_salida IS NULL desc, 
		hora_entrada IS NULL desc, 
		hora_salida desc, 
		hora_entrada desc;";
        return $this->selectAll($sql);
    }

    public function getBoletaPorFecha($fecha, $trabajador_id)
    {
        $sql = "SELECT 
        b.id AS bid, 
        b.numero AS numero, 
        b.trabajador_id AS trabajador_id, 
        b.aprobado_por AS aprobado_por, 
        ap.apellido_nombre AS aprobador_nombre,
        b.fecha_inicio AS fecha_inicio, 
        b.fecha_fin AS fecha_fin, 
        b.hora_salida AS hora_salida, 
        b.hora_entrada AS hora_entrada, 
        -- b.duracion AS duracion, 
        TO_CHAR(b.duracion ::interval, 'HH24:MI') AS duracion,
        b.razon AS razon,
        b.razon_especifica AS razon_especifica,
        b.observaciones AS observaciones, 
        b.estado_tramite AS estado_tramite, 
        b.estado  AS estado,
        b.tipo as boleta_tipo
        FROM 
            boleta AS b
            INNER JOIN trabajador AS t ON t.id = b.trabajador_id
            INNER JOIN trabajador AS ap ON ap.id = b.aprobado_por
        WHERE 
            b.estado = 'Activo' 
            AND b.estado_tramite = 'Aprobado' 
            AND b.trabajador_id = $trabajador_id
            AND '$fecha'  BETWEEN fecha_inicio AND fecha_fin 
        ORDER BY 
            b.id ASC";
        return $this->selectAll($sql);
    }


    public function getBoletaPorFechaSola($trabajador_id)
    {
        $sql = "SELECT 
        b.id AS bid, 
        b.numero AS numero, 
        b.trabajador_id AS trabajador_id, 
        b.aprobado_por AS aprobado_por, 
        ap.apellido_nombre AS aprobador_nombre,
        b.fecha_inicio AS fecha_inicio, 
        b.fecha_fin AS fecha_fin, 
        b.hora_salida AS hora_salida, 
        b.hora_entrada AS hora_entrada, 
       
        TO_CHAR(b.duracion ::interval, 'HH24:MI') AS duracion,
        b.razon AS razon,
        b.razon_especifica AS razon_especifica,
        b.observaciones AS observaciones, 
        b.estado_tramite AS estado_tramite, 
        b.estado  AS estado,
        b.tipo as boleta_tipo
        FROM 
            boleta AS b
            INNER JOIN trabajador AS t ON t.id = b.trabajador_id
            INNER JOIN trabajador AS ap ON ap.id = b.aprobado_por
        WHERE 
            b.estado = 'Activo' 
            AND b.estado_tramite = 'Aprobado' 
            AND b.trabajador_id = '$trabajador_id' 
        ORDER BY 
             b.fecha_inicio,b.fecha_fin ASC;";
        return $this->selectAll($sql);
    }

    public function getAllTrabajadorCargo()
    {
        $sql = "SELECT 
        t.id AS trabajador_id,
        t.apellido_nombre AS trabajador_nombre, 
        c.nombre AS cargo_nombre,
        t.dni AS trabajador_dni, 
        c.nivel AS cargo_nivel,
        t.estado AS trabajador_estado
        FROM 
            trabajador AS t  
        INNER JOIN 
            cargo AS c ON c.id = t.cargo_id 
        ORDER BY
        t.id ASC ;";
        return $this->selectAll($sql);
    }

    public function getTrabajadorCargo($cargo, $nivel)
    {
        $sql = "SELECT 
        t.id AS trabajador_id,
        t.apellido_nombre AS trabajador_nombre, 
        c.nombre AS cargo_nombre,
        t.dni AS trabajador_dni, 
        c.nivel AS cargo_nivel,
        t.estado AS trabajador_estado
        FROM 
            trabajador AS t  
        INNER JOIN 
            cargo AS c ON c.id = t.cargo_id 
        WHERE 
            c.nombre != '$cargo' 
            AND c.nivel > $nivel
        ORDER BY
        t.id ASC ;";
        return $this->selectAll($sql);
    }

    public function getTrabajadorCargo2($nivel)
    {
        $sql = "SELECT 
        t.id AS trabajador_id,
        t.apellido_nombre AS trabajador_nombre, 
        c.nombre AS cargo_nombre,
        t.dni AS trabajador_dni, 
        c.nivel AS cargo_nivel,
        t.estado AS trabajador_estado
        FROM 
            trabajador AS t  
        INNER JOIN 
            cargo AS c ON c.id = t.cargo_id 
        WHERE 
            c.nivel > $nivel
        ORDER BY
        t.id ASC ;";
        return $this->selectAll($sql);
    }

    public function getTrabajador($id)
    {
        $sql = "SELECT 
        t.id AS trabajador_id,
        t.apellido_nombre AS trabajador_nombre, 
        t.dni AS trabajador_dni, 
        c.nombre AS cargo_nombre,
        c.nivel AS cargo_nivel,
        t.estado AS trabajador_estado
        FROM 
            trabajador AS t  
        INNER JOIN 
            cargo AS c ON c.id = t.cargo_id 
        where 
            t.id = $id
        ORDER BY
        t.id ASC ;";
        return $this->select($sql);
    }
    public function getBoleta($id)
    {
        $sql = "SELECT * FROM boleta WHERE id = $id";
        return $this->select($sql);
    }
    public function verificar($id)
    {
        $sql = "SELECT * FROM Boleta WHERE id = '$id' ";
        return $this->select($sql);
    }

    public function verificarExistencia($fecha_inicio, $fecha_fin, $trabajador_id)
    {

        $sql = "SELECT * FROM boleta 
                WHERE 
                (fecha_inicio <= '$fecha_fin' AND 
                fecha_fin >= '$fecha_inicio') AND
            trabajador_id = $trabajador_id AND
                tipo='2' AND
                (estado_tramite = 'Pendiente' OR estado_tramite = 'Aprobado')";
        return $this->selectAll($sql);
    }

    public function verificarExistenciaFecha($fecha_inicio, $fecha_fin, $trabajador_id)
    {
       
        $sql = "SELECT * FROM boleta 
                WHERE trabajador_id = '$trabajador_id' AND
                    tipo = '2' AND
                    (estado_tramite = 'Pendiente' OR estado_tramite = 'Aprobado') AND
                    (
                        (fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_fin') OR
                        (fecha_fin BETWEEN '$fecha_inicio' AND '$fecha_fin') OR
                        (fecha_inicio <= '$fecha_inicio' AND fecha_fin >= '$fecha_fin')
                    )";
        
         // $sql = "SELECT * FROM boleta 
                // WHERE 
                //     trabajador_id = '$trabajador_id' AND
                //     tipo = '2' AND
                //     (estado_tramite = 'Pendiente' OR estado_tramite = '$fecha_fin') AND
                //     (
                //         (fecha_inicio BETWEEN '$fecha_inicio' AND '$fecha_fin') OR
                //         (fecha_fin BETWEEN '$fecha_inicio' AND '$fecha_fin') OR
                //         (fecha_inicio <= '$fecha_inicio' AND fecha_fin >= '$fecha_fin')
                //     )";
        return $this->selectAll($sql);
    }

    public function verificarExistenciaHora($fecha_inicio,$hora_salida, $hora_retorno, $trabajador_id)
    {
        $sql = "SELECT * FROM boleta 
                WHERE 
                    trabajador_id = '$trabajador_id' AND
                    tipo = '1' AND
                     fecha_inicio = '$fecha_inicio' AND
                    (estado_tramite = 'Pendiente' OR estado_tramite = 'Aprobado') AND
                    (
                        (hora_salida BETWEEN '$hora_salida' AND '$hora_retorno') OR
                        (hora_entrada BETWEEN '$hora_salida' AND '$hora_retorno') OR
                        (hora_salida <= '$hora_salida' AND hora_entrada >= '$hora_retorno'))";
        //     $sql = "SELECT * FROM boleta 
        //     WHERE 
        //     (hora_salida <= '$hora_salida' AND 
        //     hora_entrada >= '$hora_retorno') AND
        //    trabajador_id = $trabajador_id AND
        //     tipo='1' AND
        //     (estado_tramite = 'Pendiente' OR estado_tramite = 'Aprobado')" 
        //     ;

        return $this->selectAll($sql);
    }


    public function registrar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite, $tipo)
    {
        $sql = "INSERT INTO boleta (trabajador_id,aprobado_por,fecha_inicio,fecha_fin,razon,razon_especifica,estado_tramite,tipo) VALUES (?,?,?,?,?,?,?,?)";
        $array = array($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite, $tipo);
        return $this->insertar($sql, $array);
    }

    public function registrarAdmin($solicitante, $aprobador, $hora_salida, $hora_entrada, $duracion, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite, $tipo)
    {
        $sql = "INSERT INTO boleta (trabajador_id,aprobado_por,hora_salida,hora_entrada,duracion,fecha_inicio,fecha_fin,razon,razon_especifica,estado_tramite,tipo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $array = array($solicitante, $aprobador, $hora_salida, $hora_entrada, $duracion, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite,$estado_tramite, $tipo);
        return $this->insertar($sql, $array);
    }
    public function modificarAdmin($solicitante, $aprobador, $hora_salida, $hora_entrada, $duracion, $fecha_inicio, $fecha_fin, $razon, $razon_especifica,$estado_tramite, $id)
    {
        $sql = "UPDATE boleta SET trabajador_id=?,aprobado_por=?,hora_salida=?,hora_entrada=?,duracion=?,fecha_inicio=?,fecha_fin=?,razon =?,razon_especifica=?,estado_tramite=?, update_at=NOW()  WHERE id = ?";
        $array = array($solicitante, $aprobador, $hora_salida, $hora_entrada, $duracion, $fecha_inicio, $fecha_fin, $razon, $razon_especifica,$estado_tramite, $id);
        return $this->save($sql, $array);
    }

    public function modificar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id)
    {
        $sql = "UPDATE boleta SET trabajador_id=?,aprobado_por=?,fecha_inicio=?,fecha_fin=?,razon =?,razon_especifica=?, update_at=NOW()  WHERE id = ?";
        $array = array($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id);
        return $this->save($sql, $array);
    }
    public function modificarSalida($salida, $id)
    {
        $sql = "UPDATE boleta SET hora_salida = ? ,  update_at=NOW()  WHERE id = ?";
        $array = array($salida, $id);
        return $this->save($sql, $array);
    }

    public function modificarEntrada($entrada, $duracion, $id)
    {
        $sql = "UPDATE boleta SET hora_entrada = ?,duracion = ?, update_at=NOW()  WHERE id = ?";
        $array = array($entrada, $duracion, $id);
        return $this->save($sql, $array);
    }
    public function modificarHora($salida, $entrada, $id)
    {
        $sql = "UPDATE boleta SET hora_salida = ?,hora_entrada = ?, update_at=NOW()  WHERE id = ?";
        $array = array($salida, $entrada, $id);
        return $this->save($sql, $array);
    }
    public function Revisar($id, $accion, $observacion)
    {
        $sql = "UPDATE boleta SET estado_tramite = ? , observaciones=? WHERE id = ?";
        $array = array($accion, $observacion, $id);
        return $this->save($sql, $array);
    }

    public function registrarJustificacionHoras($justificacion,$fecha_inicio,$solicitante){
        $sql = "UPDATE asistencia SET justificacion=?  WHERE fecha=? AND trabajador_id = ?";
        $array = array($justificacion,$fecha_inicio,$solicitante);
        return $this->save($sql, $array);

    }
    public function obtenerBoletas($solicitante,$fecha_inicio){
        $sql ="SELECT count(*) as cantidad FROM boleta WHERE trabajador_id='$solicitante' AND fecha_inicio='$fecha_inicio' AND tipo='1'";
        return $this->select($sql);
    }


    public function registrarlog($usuario, $accion, $tabla, $detalles)
    {
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario, $accion, $tabla, $detalles);
        return $this->save($sql, $array);
    }
}
