<?php
class PersonaModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPersonas()
    {
        $sql = "SELECT * 
    FROM persona
    ORDER BY nombre;";
        return $this->selectAll($sql);
    }

    public function buscar($id)
    {
        $sql = "SELECT * from persona where id = $id";
        return $this->select($sql);
    }

    public function listarReceptor($id)
    {
        $sql = "SELECT * FROM persona WHERE id !=  $id order by nombre;";
        return $this->selectAll($sql);
    }

    public function verificardni($dni)
    {
        $sql = "SELECT id,numero_documento FROM Persona WHERE numero_documento = '$dni' ";
        return $this->select($sql);
    }

    public function verificarruc($ruc)
    {
        $sql = "SELECT id,numero_ruc FROM Persona WHERE numero_ruc = '$ruc' ";
        return $this->select($sql);
    }
    public function findOneByDate($dia, $mes)
    {
        $sql = "SELECT * FROM festividad WHERE dia = '$dia' and mes = '$mes' ";
        return $this->select($sql);
    }

    public function registrar($tipo_persona, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular)
    {
        $sql = "INSERT INTO persona (tipo_persona,numero_documento,numero_ruc,nombre,direccion,ubigeo,contacto_email,contacto_telefono) VALUES (?,?,?,?,?,?,?,?)";
        $array = array($tipo_persona, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular);
        return $this->insertar($sql, $array);
    }
    public function modificar($tipo_persona, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id)
    {
        $sql = "UPDATE persona SET tipo_persona = ?, 
                numero_documento = ?, 
                numero_ruc = ?, 
                nombre = ?, 
                direccion = ?, 
                ubigeo = ?, 
                contacto_email = ?, 
                contacto_telefono = ?, 
                estado = ?, 
                updated_at = NOW()   WHERE id = ?";
        $array = array($tipo_persona, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id);
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
