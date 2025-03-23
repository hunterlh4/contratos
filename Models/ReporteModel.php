<?php
class ReporteModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getReporteTrabajadorAll()
    {

        $sql = "SELECT * FROM asistencia ORDER BY id asc ";
        // $sql = "SELECT T.id as tid,T.estado as testado from trabajadores as T ORDER BY id ASC";
        return $this->selectAll($sql);
    }
    public function Reporte_Trabajador($id, $mes, $anio)
    {
        $sql = "SELECT 
                t.apellido_nombre AS trabajador_nombre,
                fecha,
                licencia,
                TO_CHAR(entrada, 'HH24:MI') AS entrada,
                TO_CHAR(salida, 'HH24:MI') AS salida,
                TO_CHAR(total_reloj, 'HH24:MI') AS total_reloj,
                TO_CHAR(total, 'HH24:MI') AS total,
                TO_CHAR(reloj_1, 'HH24:MI') AS reloj_1,
                TO_CHAR(reloj_2, 'HH24:MI') AS reloj_2,
                TO_CHAR(reloj_3, 'HH24:MI') AS reloj_3,
                TO_CHAR(reloj_4, 'HH24:MI') AS reloj_4,
                TO_CHAR(reloj_5, 'HH24:MI') AS reloj_5,
                TO_CHAR(reloj_6, 'HH24:MI') AS reloj_6,
                TO_CHAR(reloj_7, 'HH24:MI') AS reloj_7,
                TO_CHAR(reloj_8, 'HH24:MI') AS reloj_8,
                justificacion,

                CASE WHEN tardanza_cantidad <> 0 THEN 1 ELSE 0 END AS tardanza_cantidad,
                CASE WHEN licencia = 'NMS' THEN 1 ELSE 0 END AS inasistencia
                FROM 
                        asistencia AS a
                INNER JOIN trabajador as t ON t.id = a.trabajador_id
                WHERE 
                        EXTRACT(MONTH FROM fecha) = $mes
                        AND EXTRACT(YEAR FROM fecha) = $anio
                        AND trabajador_id = $id
                ORDER BY fecha asc";

        return $this->selectAll($sql);
    }

    public function reporteGeneralLicencia($mes, $anio)
    {
        $mes_formateado = sprintf("%02d", $mes);
        //  $sql = "SELECT 
        //         t.apellido_nombre AS trabajador_nombre,
        //         fecha,
        //         licencia,
        //         tardanza_cantidad,
        //         justificacion


        //         FROM 
        //                 asistencia AS a
        //         INNER JOIN trabajador as t ON t.id = a.trabajador_id
        //         WHERE 
        //                 EXTRACT(MONTH FROM fecha) = $mes
        //                 AND EXTRACT(YEAR FROM fecha) = $anio

        //         ORDER BY t.apellido_nombre, fecha asc";

        $sql = "WITH dias_del_mes AS (
                SELECT generate_series(
                         DATE_TRUNC('month', DATE '$anio-$mes_formateado-01'),  -- Primer día del mes
                        (DATE_TRUNC('month', DATE '$anio-$mes_formateado-01') + INTERVAL '1 month - 1 day'),  -- Último día del mes
                        INTERVAL '1 day'
                    ) AS fecha
                )

                SELECT
                    t.apellido_nombre AS trabajador_nombre,
                    STRING_AGG(
                        TO_CHAR(DATE_TRUNC('day', d.fecha), 'YYYY-MM-DD') || '_' || a.licencia,
                        ' '
                    ) AS detalles
                FROM
                    dias_del_mes d
                LEFT JOIN asistencia a ON DATE_TRUNC('day', a.fecha) = d.fecha
                LEFT JOIN trabajador t ON t.id = a.trabajador_id
                WHERE t.apellido_nombre IS NOT NULL
                GROUP BY
                    trabajador_nombre
                ORDER BY
                    trabajador_nombre ASC";
        return $this->selectAll($sql);
    }

    public function reporteGeneralTardanza($mes, $anio)
    {
        $mes_formateado = sprintf("%02d", $mes);


        $sql = "WITH dias_del_mes AS (
                SELECT generate_series(
                         DATE_TRUNC('month', DATE '$anio-$mes_formateado-01'),  -- Primer día del mes
                        (DATE_TRUNC('month', DATE '$anio-$mes_formateado-01') + INTERVAL '1 month - 1 day'),  -- Último día del mes
                        INTERVAL '1 day'
                    ) AS fecha
                )

                SELECT
                    t.apellido_nombre AS trabajador_nombre,
                     TO_CHAR(INTERVAL '1 second' * SUM(EXTRACT(EPOCH FROM a.tardanza)), 'HH24:MI') AS suma_tardanza,
                    STRING_AGG(
                        TO_CHAR(DATE_TRUNC('day', d.fecha), 'YYYY-MM-DD') || '_' || TO_CHAR(a.tardanza, 'HH24:MI'),
                        ' '
                    ) AS detalles
                FROM
                    dias_del_mes d
                LEFT JOIN asistencia a ON DATE_TRUNC('day', a.fecha) = d.fecha
                LEFT JOIN trabajador t ON t.id = a.trabajador_id
                WHERE t.apellido_nombre IS NOT NULL
                GROUP BY
                    trabajador_nombre
                ORDER BY
                    trabajador_nombre ASC";
        return $this->selectAll($sql);
    }

    public function getTrabajador($id, $mes, $anio)
    {

        $sql = "SELECT 
        t.apellido_nombre AS trabajador_nombre, 
        b.fecha_inicio AS fecha,
        hd.hora_entrada AS horario_entrada,
        hd.hora_salida AS horario_salida, 
        CASE WHEN b.razon = 'Motivos Particulares' THEN 1 ELSE 0 END AS total_motivos_particulares
        FROM 
            trabajador AS t
        INNER JOIN 
            horariodetalle AS hd ON hd.id = t.horariodetalle_id
        left JOIN 
            boleta AS b ON b.trabajador_id = t.id AND EXTRACT(MONTH FROM b.fecha_inicio) = $mes AND EXTRACT(YEAR FROM b.fecha_inicio) = $anio
        WHERE 
        t.id = $id";
        return $this->selectAll($sql);
    }

    public function obtenerHorarioDetalle($trabajador_id){
        $sql ="SELECT  t.apellido_nombre AS trabajador_nombre,  hd.hora_entrada AS horario_entrada,
        hd.hora_salida AS horario_salida FROM trabajador AS t INNER JOIN horariodetalle AS hd ON hd.id = t.horariodetalle_id WHERE t.id = 812 LIMIT 1";
        return $this->select($sql);
    }

    public function obtenerBoletas($trabajador_id,$mes,$anio){
        $sql ="SELECT 
        -- t.apellido_nombre AS trabajador_nombre, 
        b.fecha_inicio AS fecha,
        CASE WHEN b.razon = 'Motivos Particulares' THEN 1 ELSE 0 END AS total_motivos_particulares
        FROM 
            trabajador AS t
        
        inner JOIN 
            boleta AS b ON b.trabajador_id = t.id AND EXTRACT(MONTH FROM b.fecha_inicio) = $mes AND EXTRACT(YEAR FROM b.fecha_inicio) = $anio
        WHERE 
        t.id = '$trabajador_id'";
        return $this->selectAll($sql);
    
    }

    public function getSeguimiento($id)
    {
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
    // kardex leyenda
    public function obtenerLeyendaAsistencia($trabajador_id, $anio, $mes_inicio, $mes_fin){
        $sql ="SELECT 
                    t.apellido_nombre AS trabajador_nombre,
                    fecha,
                TO_CHAR(tardanza, 'HH24:MI') AS tardanaza,
                    licencia
                FROM 
                    asistencia AS a
                INNER JOIN trabajador as t ON t.id = a.trabajador_id
                WHERE 
                    EXTRACT(YEAR FROM fecha) = $anio
                    AND EXTRACT(MONTH FROM fecha) BETWEEN $mes_inicio AND $mes_fin
                    AND trabajador_id = '$trabajador_id'
                ORDER BY 
                    fecha ASC";
        return $this->selectAll($sql);
    }
    // kardex boleta leyenda
    public function obtenerBoletaLicenciaDuracion($trabajador_id, $anio, $mes_inicio, $mes_fin){
        $sql ="SELECT id,razon, TO_CHAR(duracion, 'HH24:MI') AS duracion,fecha_inicio,tipo FROM boleta 
                WHERE 
                    EXTRACT(YEAR FROM fecha_inicio) = $anio
                    AND trabajador_id = '$trabajador_id'
                    AND estado_tramite = 'Aprobado'
                    AND EXTRACT(MONTH FROM fecha_inicio) BETWEEN $mes_inicio AND  $mes_fin
                ORDER BY 
                    fecha_inicio ASC";
        return $this->selectAll($sql);
    }
    // kadex hora extra
    public function obtenerTotalHoraExtra($trabajador_id, $anio, $mes_inicio, $mes_fin)
    {
        $sql = "WITH meses AS (
                    SELECT GENERATE_SERIES($mes_inicio, $mes_fin) AS mes
                ),
                datos_filtrados AS (
                    SELECT 
                        EXTRACT(MONTH FROM fecha_desde) AS mes,
                        diferencia
                    FROM 
                        horas_extra
                    WHERE 
                        EXTRACT(MONTH FROM fecha_desde) BETWEEN $mes_inicio AND $mes_fin
                        AND EXTRACT(YEAR FROM fecha_desde) = $anio
                        AND trabajador_id = '$trabajador_id'
                        AND estado = 'Activo'
                        AND tipo = 'aumentar'
                ),
                conteo_y_suma_por_mes AS (
                    SELECT 
                        mes,
                        COUNT(*) AS total_registros,
                        COALESCE(SUM(diferencia), INTERVAL '00:00') AS total_diferencia
                    FROM 
                        datos_filtrados
                    GROUP BY 
                        mes
                )
                SELECT
                    m.mes,
                    COALESCE(c.total_registros, 0) AS total_registros,
                    TO_CHAR(COALESCE(c.total_diferencia, INTERVAL '00:00'), 'HH24:MI') AS total_diferencia
                FROM
                    meses m
                LEFT JOIN
                    conteo_y_suma_por_mes c ON m.mes = c.mes
                ORDER BY
                    m.mes";
        return $this->selectAll($sql);
    }
    // kadex tardanza
    public function obtenerTotalTardanza($trabajador_id, $anio, $mes_inicio, $mes_fin)
    {
        // $sql = " WITH meses AS (
        //             SELECT generate_series($mes_inicio, $mes_fin) AS mes
        //         )
        //         SELECT 
        //             m.mes,
        //             COALESCE(COUNT(a.tardanza_cantidad), 0) AS total_tardanzas,
        //             TO_CHAR(
        //                 COALESCE(SUM(a.tardanza), INTERVAL '00:00')::interval,
        //                 'HH24:MI'
        //             ) AS total_tiempo_tardanza
        //         FROM 
        //             meses m
        //         LEFT JOIN 
        //             asistencia a ON EXTRACT(MONTH FROM a.fecha) = m.mes
        //             AND EXTRACT(YEAR FROM a.fecha) = '$anio'  -- Ajusta el año según sea necesario
        //             AND a.tardanza_cantidad > 0
        //             AND trabajador_id = '$trabajador_id'
        //         GROUP BY 
        //             m.mes
        //         ORDER BY 
        //             m.mes";

        $sql ="WITH meses AS (
                    SELECT GENERATE_SERIES($mes_inicio, $mes_fin) AS mes
                ),
                datos_filtrados AS (
                    SELECT 
                        EXTRACT(MONTH FROM fecha) AS mes,
                        tardanza_cantidad, 
                        COALESCE(tardanza, '00:00') AS tardanza
                    FROM 
                        asistencia
                    WHERE 
                        EXTRACT(MONTH FROM fecha) BETWEEN $mes_inicio AND $mes_fin
                        AND EXTRACT(YEAR FROM fecha) = $anio
                        AND tardanza_cantidad > 0
                        AND trabajador_id = '$trabajador_id'
                ),
                conteo_y_suma_por_mes AS (
                    SELECT 
                        mes,
                        COUNT(*) AS total_registros,
                        COALESCE(SUM(tardanza::interval), '00:00'::interval) AS total_tardanza
                    FROM 
                        datos_filtrados
                    GROUP BY 
                        mes
                )
                SELECT
                    m.mes,
                    COALESCE(c.total_registros, 0) AS total_registros,
                    TO_CHAR(COALESCE(c.total_tardanza, '00:00'::interval), 'HH24:MI') AS total_tardanza
                FROM
                    meses m
                LEFT JOIN
                    conteo_y_suma_por_mes c ON m.mes = c.mes
                ORDER BY
                    m.mes";
        return $this->selectAll($sql);
    }
    // kadex inasistencias injustificada
    public function obtenerTotalInasistenciaInjustificada($trabajador_id, $anio, $mes_inicio, $mes_fin)
    {
        $sql = "WITH meses AS (
                    SELECT GENERATE_SERIES($mes_inicio, $mes_fin) AS mes
                ),
                asistencia_filtrada AS (
                    SELECT 
                        EXTRACT(MONTH FROM fecha) AS mes,
                        licencia
                    FROM 
                        asistencia
                    WHERE 
                        EXTRACT(MONTH FROM fecha) BETWEEN $mes_inicio AND $mes_fin
                        AND EXTRACT(YEAR FROM fecha) = '$anio' -- Ajusta el año según sea necesario
                        AND licencia IN ('NME', 'NMS', '+30')
                        AND trabajador_id = '$trabajador_id'
                ),
                conteo_por_mes AS (
                    SELECT 
                        mes,
                        licencia,
                        COUNT(*) AS total
                    FROM 
                        asistencia_filtrada
                    GROUP BY 
                        mes, licencia
                ),
                total_por_mes AS (
                    SELECT 
                        mes,
                        SUM(CASE WHEN licencia = 'NME' THEN total ELSE 0 END) AS total_NME,
                        SUM(CASE WHEN licencia = 'NMS' THEN total ELSE 0 END) AS total_NMS,
                        SUM(CASE WHEN licencia = '+30' THEN total ELSE 0 END) AS total_30
                    FROM 
                        conteo_por_mes
                    GROUP BY 
                        mes
                )
                SELECT
                    m.mes,
                    COALESCE(t.total_NME, 0) AS total_NME,
                    COALESCE(t.total_NMS, 0) AS total_NMS,
                    COALESCE(t.total_30, 0) AS total_30,
                    COALESCE(t.total_NME, 0) + COALESCE(t.total_NMS, 0) + COALESCE(t.total_30, 0) AS total_general
                FROM
                    meses m
                LEFT JOIN
                    total_por_mes t ON m.mes = t.mes
                ORDER BY
                    m.mes";
        return $this->selectAll($sql);
    }
    // kadex permisos laborales por horas
    public function obtenerTotalPermisoLaboral($trabajador_id, $anio, $mes_inicio, $mes_fin)
    {
        $sql ="WITH meses AS (
                    SELECT GENERATE_SERIES($mes_inicio, $mes_fin) AS mes
                ),
                boletas_filtradas AS (
                    SELECT 
                        EXTRACT(MONTH FROM fecha_inicio) AS mes,
                        razon
                    FROM 
                        boleta
                    WHERE 
                        EXTRACT(MONTH FROM fecha_inicio) BETWEEN $mes_inicio AND $mes_fin
                        AND EXTRACT(YEAR FROM fecha_inicio) = $anio -- Ajusta el año según sea necesario
                        AND trabajador_id = '$trabajador_id'
                        AND estado_tramite = 'Aprobado'
                        AND tipo = '1'
                        AND razon IN ('CS', 'DHE', 'AP', 'ESS', 'CAP', 'LM/LP', 'C.ESP', 'OTR')
                ),
                conteo_por_mes AS (
                    SELECT 
                        mes,
                        razon,
                        COUNT(*) AS total
                    FROM 
                        boletas_filtradas
                    GROUP BY 
                        mes, razon
                ),
                total_por_mes AS (
                    SELECT 
                        mes,
                        SUM(CASE WHEN razon = 'CS' THEN total ELSE 0 END) AS total_CS,
                        SUM(CASE WHEN razon = 'DHE' THEN total ELSE 0 END) AS total_DHE,
                        SUM(CASE WHEN razon = 'AP' THEN total ELSE 0 END) AS total_AP,
                        SUM(CASE WHEN razon = 'ESS' THEN total ELSE 0 END) AS total_ESS,
                        SUM(CASE WHEN razon = 'CAP' THEN total ELSE 0 END) AS total_CAP,
                        SUM(CASE WHEN razon = 'LM/LP' THEN total ELSE 0 END) AS total_LMLP,
                        SUM(CASE WHEN razon = 'C.ESP' THEN total ELSE 0 END) AS total_CESP,
                        SUM(CASE WHEN razon = 'OTR' THEN total ELSE 0 END) AS total_OTR
                    FROM 
                        conteo_por_mes
                    GROUP BY 
                        mes
                )
                SELECT
                    m.mes,
                    COALESCE(t.total_CS, 0) AS total_CS,
                    COALESCE(t.total_DHE, 0) AS total_DHE,
                    COALESCE(t.total_AP, 0) AS total_AP,
                    COALESCE(t.total_ESS, 0) AS total_ESS,
                    COALESCE(t.total_CAP, 0) AS total_CAP,
                    COALESCE(t.total_LMLP, 0) AS total_LMLP,
                    COALESCE(t.total_CESP, 0) AS total_CESP,
                    COALESCE(t.total_OTR, 0) AS total_OTR,
                    COALESCE(t.total_CS, 0) + COALESCE(t.total_DHE, 0) + COALESCE(t.total_AP, 0) + 
                    COALESCE(t.total_ESS, 0) + COALESCE(t.total_CAP, 0) + COALESCE(t.total_LMLP, 0) + 
                    COALESCE(t.total_CESP, 0) + COALESCE(t.total_OTR, 0) AS total_general
                FROM
                    meses m
                LEFT JOIN
                    total_por_mes t ON m.mes = t.mes
                ORDER BY
                    m.mes";
        return $this->selectAll($sql);
    }
    public function obtenerTotalInasistenciaJustificada($trabajador_id, $anio, $mes_inicio, $mes_fin)
    {
        $sql = " WITH meses AS (
                    SELECT GENERATE_SERIES($mes_inicio,$mes_fin) AS mes
                ),
                boletas_filtradas AS (
                    SELECT 
                        EXTRACT(MONTH FROM fecha_inicio) AS mes,
                        razon
                    FROM 
                        boleta
                    WHERE 
                        EXTRACT(MONTH FROM fecha_inicio) BETWEEN $mes_inicio AND $mes_fin
                        AND EXTRACT(YEAR FROM fecha_inicio) = $anio
                        AND trabajador_id = '$trabajador_id'
                        AND estado_tramite = 'Aprobado'
                        AND tipo = '2'
                        AND razon IN ('AP', 'CS', 'DHE', 'O', 'CAP', 'D', 'AV', 'V', 'LE', 'LM/LP', 'LIC. F.G.', 'LIC. GEST.', 'C.ESP', 'OTR')
                ),
                conteo_por_mes AS (
                    SELECT 
                        mes,
                        razon,
                        COUNT(*) AS total
                    FROM 
                        boletas_filtradas
                    GROUP BY 
                        mes, razon
                ),
                total_por_mes AS (
                    SELECT 
                        mes,
                        SUM(CASE WHEN razon = 'AP' THEN total ELSE 0 END) AS total_AP,
                        SUM(CASE WHEN razon = 'CS' THEN total ELSE 0 END) AS total_CS,
                        SUM(CASE WHEN razon = 'DHE' THEN total ELSE 0 END) AS total_DHE,
                        SUM(CASE WHEN razon = 'O' THEN total ELSE 0 END) AS total_O,
                        SUM(CASE WHEN razon = 'CAP' THEN total ELSE 0 END) AS total_CAP,
                        SUM(CASE WHEN razon = 'D' THEN total ELSE 0 END) AS total_D,
                        SUM(CASE WHEN razon = 'AV' THEN total ELSE 0 END) AS total_AV,
                        SUM(CASE WHEN razon = 'V' THEN total ELSE 0 END) AS total_V,
                        SUM(CASE WHEN razon = 'LE' THEN total ELSE 0 END) AS total_LE,
                        SUM(CASE WHEN razon = 'LM/LP' THEN total ELSE 0 END) AS total_LMLP,
                        SUM(CASE WHEN razon = 'LIC. F.G.' THEN total ELSE 0 END) AS total_LIC_FG,
                        SUM(CASE WHEN razon = 'LIC. GEST.' THEN total ELSE 0 END) AS total_LIC_GEST,
                        SUM(CASE WHEN razon = 'C.ESP' THEN total ELSE 0 END) AS total_CESP,
                        SUM(CASE WHEN razon = 'OTR' THEN total ELSE 0 END) AS total_OTR
                    FROM 
                        conteo_por_mes
                    GROUP BY 
                        mes
                )
                SELECT
                    m.mes,
                    COALESCE(t.total_AP, 0) AS total_AP,
                    COALESCE(t.total_CS, 0) AS total_CS,
                    COALESCE(t.total_DHE, 0) AS total_DHE,
                    COALESCE(t.total_O, 0) AS total_O,
                    COALESCE(t.total_CAP, 0) AS total_CAP,
                    COALESCE(t.total_D, 0) AS total_D,
                    COALESCE(t.total_AV, 0) AS total_AV,
                    COALESCE(t.total_V, 0) AS total_V,
                    COALESCE(t.total_LE, 0) AS total_LE,
                    COALESCE(t.total_LMLP, 0) AS total_LMLP,
                    COALESCE(t.total_LIC_FG, 0) AS total_LIC_FG,
                    COALESCE(t.total_LIC_GEST, 0) AS total_LIC_GEST,
                    COALESCE(t.total_CESP, 0) AS total_CESP,
                    COALESCE(t.total_OTR, 0) AS total_OTR,
                    COALESCE(t.total_AP, 0) + COALESCE(t.total_CS, 0) + COALESCE(t.total_DHE, 0) + 
                    COALESCE(t.total_O, 0) + COALESCE(t.total_CAP, 0) + COALESCE(t.total_D, 0) + 
                    COALESCE(t.total_AV, 0) + COALESCE(t.total_V, 0) + COALESCE(t.total_LE, 0) + 
                    COALESCE(t.total_LMLP, 0) + COALESCE(t.total_LIC_FG, 0) + COALESCE(t.total_LIC_GEST, 0) + 
                    COALESCE(t.total_CESP, 0) + COALESCE(t.total_OTR, 0) AS total_general
                FROM
                    meses m
                LEFT JOIN
                    total_por_mes t ON m.mes = t.mes
                ORDER BY
                    m.mes";
        return $this->selectAll($sql);
    }
    public function registrarlog($usuario, $accion, $tabla, $detalles)
    {
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario, $accion, $tabla, $detalles);
        return $this->save($sql, $array);
    }
}
