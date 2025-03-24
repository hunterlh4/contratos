<?php
class ContratoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getContratos()
    {
        $sql = "SELECT 
    c.id as contrato_id,
    tc.nombre AS tipo_contrato_nombre,
    tc.sigla AS tipo_contrato_sigla,
    c.codigo_correlativo AS contrato_codigo_correlativo,
    
    -- Datos del abogado (Personal)
    pa.nombre AS personal_abogado_nombre, 
    pa.apellido_paterno AS personal_abogado_apellido_paterno, 
    pa.apellido_materno AS personal_abogado_apellido_materno,

    -- Datos del aprobador (Personal)
    p_ap.nombre AS personal_aprobador_nombre,
    p_ap.apellido_paterno AS personal_aprobador_apellido_paterno, 
    p_ap.apellido_materno AS personal_aprobador_apellido_materno,

    -- Datos del emisor (Persona)
    pe.nombre AS persona_emisor_nombre,

    -- Datos del receptor (Persona)
    pr.nombre AS persona_receptor_nombre,

    -- Etapa del contrato
    ec.nombre AS etapa_contrato_nombre,

    -- Fechas importantes
    c.created_at as contrato_fecha_solicitada,
    c.fecha_suscripcion as contrato_fecha_suscripcion,
    c.fecha_aprobacion as contrato_fecha_aprobada,
    c.fecha_inicio as contrato_fecha_inicio,
    c.fecha_fin as contrato_fecha_fin,

    -- Datos financieros
    c.monto,
    m.nombre AS moneda_nombre,
    b.nombre AS banco_nombre,
    c.cuenta_bancaria,

    -- Ubicación
    c.ubigeo,
    c.direccion,

    -- Estado del contrato
    c.alerta_dia,
    c.alerta_activa

FROM contrato c
LEFT JOIN tipo_contrato tc ON c.tipo_contrato_id = tc.id
LEFT JOIN personal pa ON c.personal_abogado_id = pa.id
LEFT JOIN personal p_ap ON c.personal_aprobador_id = p_ap.id
LEFT JOIN persona pe ON c.persona_emisor_id = pe.id
LEFT JOIN persona pr ON c.persona_receptor_id = pr.id
LEFT JOIN etapa_contrato ec ON c.etapa_contrato_id = ec.id
LEFT JOIN moneda m ON c.moneda_id = m.id
LEFT JOIN banco b ON c.banco_id = b.id
    ORDER BY c.created_at;";
        return $this->selectAll($sql);
    }

    public function buscar($id)
    {
        $sql = "SELECT * from Contrato where id = $id";
        return $this->select($sql);
    }

    public function verificardni($dni)
    {
        $sql = "SELECT id,numero_documento FROM Contrato WHERE numero_documento = '$dni' ";
        return $this->select($sql);
    }

    public function verificarruc($ruc)
    {
        $sql = "SELECT id,numero_ruc FROM Contrato WHERE numero_ruc = '$ruc' ";
        return $this->select($sql);
    }
    public function findOneByDate($dia, $mes)
    {
        $sql = "SELECT * FROM festividad WHERE dia = '$dia' and mes = '$mes' ";
        return $this->select($sql);
    }

    public function registrar($tipo_Contrato, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular)
    {
        $sql = "INSERT INTO Contrato (tipo_Contrato,numero_documento,numero_ruc,nombre,direccion,ubigeo,contacto_email,contacto_telefono) VALUES (?,?,?,?,?,?,?,?)";
        $array = array($tipo_Contrato, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular);
        return $this->insertar($sql, $array);
    }
    public function modificar($tipo_Contrato, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id)
    {
        $sql = "UPDATE Contrato SET tipo_Contrato = ?, 
                numero_documento = ?, 
                numero_ruc = ?, 
                nombre = ?, 
                direccion = ?, 
                ubigeo = ?, 
                contacto_email = ?, 
                contacto_telefono = ?, 
                estado = ?, 
                updated_at = NOW()   WHERE id = ?";
        $array = array($tipo_Contrato, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id);
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
