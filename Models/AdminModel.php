<?php
class AdminModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    // public function getLogin($username)
    // {
    //     $sql = "SELECT * FROM usuario WHERE username = '$username'";
    //     return $this->select($sql);
    // }
    public function getUsuarioId($id)
    {
        $sql = "SELECT id,nombre,apellido,username,rol_id FROM usuario WHERE id = '$id'";
        return $this->select($sql);
    }
    public function getUsuarioIdclave($id)
    {
        $sql = "SELECT id,'password' FROM usuario WHERE id = '$id'";
        return $this->select($sql);
    }
    public function usuario_actualizar($id, $pass1)
    {
        $sql = "UPDATE usuario SET password = ? ,update_at = NOW()  WHERE id  = ?";
        $array = array(password_hash($pass1, PASSWORD_BCRYPT), $id);
        return $this->save($sql, $array);
    }
    public function NotificacionTotal()
    {
        // $sql = "SELECT COUNT(*) FROM notificacion 
        //         inner join usuario 
        //         ON notificacion.usuario_id = usuario.id
        //         where usuario.estado = 'Pendiente'";
        $sql = "SELECT COUNT(*) from usuario where estado = 'Pendiente'";
        return $this->select($sql);
    }
    public function Notificaciones()
    {
        // $sql = "SELECT n.mensaje as mensaje,u.username AS username,u.nombre AS nombre,u.apellido AS apellido ,n.fecha_creacion AS fecha_creacion,u.estado AS estado
        //         FROM notificacion AS n
        //         INNER JOIN usuario AS u
        //         ON u.id=n.usuario_id
        //         WHERE u.estado='Pendiente'
        //         ORDER BY fecha_creacion DESC
        //         ";
        // $sql = "SELECT username,nombre,apellido,create_at, estado 
        //         FROM usuario 
        //         WHERE estado='Pendiente' ORDER BY create_at DESC";
        // return $this->selectAll($sql);
    }
}
