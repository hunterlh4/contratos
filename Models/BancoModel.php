<?php
class BancoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function listar()
    {
        $sql = "SELECT * 
    FROM Banco
    ORDER BY nombre;";
        return $this->selectAll($sql);
    }

    public function buscar($id)
    {
        $sql = "SELECT * from Banco where id = $id";
        return $this->select($sql);
    }



    // public function verificardni($dni)
    // {
    //     $sql = "SELECT id,numero_documento FROM Banco WHERE numero_documento = '$dni' ";
    //     return $this->select($sql);
    // }



    // public function registrar($tipo_Banco, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular)
    // {
    //     $sql = "INSERT INTO Banco (tipo_Banco,numero_documento,numero_ruc,nombre,direccion,ubigeo,contacto_email,contacto_telefono) VALUES (?,?,?,?,?,?,?,?)";
    //     $array = array($tipo_Banco, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular);
    //     return $this->insertar($sql, $array);
    // }
    // public function modificar($tipo_Banco, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id)
    // {
    //     $sql = "UPDATE Banco SET tipo_Banco = ?, 
    //             numero_documento = ?, 
    //             numero_ruc = ?, 
    //             nombre = ?, 
    //             direccion = ?, 
    //             ubigeo = ?, 
    //             contacto_email = ?, 
    //             contacto_telefono = ?, 
    //             estado = ?, 
    //             updated_at = NOW()   WHERE id = ?";
    //     $array = array($tipo_Banco, $dni, $ruc, $nombre, $direccion, $ubigeo, $email, $celular, $estado, $id);
    //     return $this->save($sql, $array);
    // }

    // public function delete($id)
    // {
    //     $sql = "DELETE FROM festividad where id='$id'";
    //     return $this->eliminar($sql);
    // }
    // public function createLog($usuario, $accion, $tabla, $detalles)
    // {
    //     $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
    //     $array = array($usuario, $accion, $tabla, $detalles);
    //     return $this->save($sql, $array);
    // }
}
