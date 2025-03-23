<?php
class RegistroModel extends Query
{
    public function buscarUsuario($username)
    {
        $sql = "SELECT * FROM usuario WHERE username = '$username'";
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
        FROM direccion as d LEFT JOIN equipo as e on d.equipo_id = e.id 
        WHERE d.estado ='Activo' 
        order by d.nombre";
        return $this->selectAll($sql);
    }

    public function validarUsuario($usuario){
        $sql = "SELECT * FROM usuario where username='$usuario' ";
        return $this->selectAll($sql);
    }

    public function obtenerUsuario($usuario){
        $sql = "SELECT * FROM usuario where username='$usuario' ";
        return $this->select($sql);
    }

    public function registrar($dni, $fecha_nacimiento, $nombre,$apellido, $usuario, $password, $direccion){
        $sql = "INSERT INTO usuario (dni,nacimiento,nombre,apellido,username,password,direccion,nivel,estado) VALUES (?,?,?,?,?,?,?,5,'Pendiente')";
        $array = array($dni, $fecha_nacimiento,$nombre,$apellido, $usuario, $password, $direccion);
        return $this->insertar($sql, $array);
    }
    // public function mensajeria($usuario,$mensaje){
    //     $sql ="INSERT INTO mensajes (usuario_id, mensaje) VALUES (?, ?)";
    //     $array = [$usuario,$mensaje];
    //     return $this->insertar($sql, $array);
    // }
}
