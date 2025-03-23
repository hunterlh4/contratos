<?php
class LoginModel extends Query
{

    public function usuario_conectado($id)
    {
        $sql = "SELECT * FROM usuario_conectado WHERE usuario_id = '$id'";
        return $this->select($sql);
    }
    public function registrar_conectado($id)
    {
        $sql = "INSERT INTO usuario_conectado (usuario_id) VALUES (?)";
        $array = array($id);
        return $this->insertar($sql, $array);
    }
    public function modificar_conectado($id)
    {
        $sql = "UPDATE usuario_conectado SET update_at = NOW() WHERE usuario_id  = ?";
        $array = array($id);
        return $this->save($sql, $array);
    }
    public function getLogin($username)
    {
        $sql = "SELECT * FROM usuario WHERE username = '$username'";
        return $this->select($sql);
    }
}
