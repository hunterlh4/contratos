<?php
class UsuarioModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuarios()
    {
        $sql = "SELECT 
    usuario.id AS usuario_id, 
    usuario.username AS usuario_username, 
    usuario.estado AS usuario_estado, 
    usuario.sistema AS usuario_sistema,

    -- Datos del personal asociado
    personal.id AS personal_id,
    personal.nombre AS personal_nombre, 
    personal.apellido_paterno AS personal_apellido_paterno,
    personal.apellido_materno AS personal_apellido_materno,  
    personal.dni AS personal_dni, 
    personal.correo AS personal_correo, 

    -- Datos del rol asociado
    rol.id AS rol_id,
    rol.nombre AS rol_nombre,

    -- Datos del área asociada a personal
    area.id AS area_id,
    area.nombre AS area_nombre,

    -- Datos del cargo asociado a personal
    cargo.id AS cargo_id,
    cargo.nombre AS cargo_nombre

FROM usuario 
LEFT JOIN personal ON personal.id = usuario.personal_id 
LEFT JOIN rol ON rol.id = usuario.rol_id
LEFT JOIN area ON area.id = personal.area_id  -- Relación entre personal y área
LEFT JOIN cargo ON cargo.id = personal.cargo_id  -- Relación entre personal y cargo

ORDER BY 
    CASE 
        WHEN personal.dni IS NULL OR personal.dni = '' THEN 0
        ELSE 1
    END ASC,
    personal.dni ASC;";

        return $this->selectAll($sql);
    }
    public function getTrabajadores()
    {
        $sql = "SELECT  id,apellido_nombre,dni,estado from trabajador 
        where estado = 'Activo' 
        order by apellido_nombre asc ";
        return $this->selectAll($sql);
    }

    public function getTrabajadoresconBuscar($id)
    {
        $sql = "SELECT t.id AS id, t.apellido_nombre AS apellido_nombre, t.dni AS dni, t.estado AS estado
                FROM trabajador AS t
                WHERE t.estado = 'Activo'
                UNION
                SELECT t.id AS id, t.apellido_nombre AS apellido_nombre, t.dni AS dni, t.estado AS estado
                FROM trabajador AS t
                INNER JOIN usuario AS u ON t.id = u.trabajador_id
                WHERE u.id = $id
                ORDER BY apellido_nombre;";
        return $this->selectAll($sql);
    }
    public function getUsuarios2()
    {
        $sql = "SELECT id, nombre, apellido, estado FROM usuario ";
        return $this->selectAll($sql);
    }
    public function registrar($usuario, $password, $sistema, $personal_id, $rol_id)
    {
        $sql = "INSERT INTO usuario (username,password,sistema, personal_id,rol_id) VALUES (?,?,?,?,?)";
        $array = array($usuario, $password,  $sistema, $personal_id, $rol_id);

        return $this->insertar($sql, $array);
    }
    public function verificarCorreo($correo)
    {
        $sql = "SELECT correo FROM usuario WHERE correo = '$correo' AND estado = 'Activo";
        return $this->select($sql);
    }
    public function verificarUsuario($usuario)
    {
        $sql = "SELECT id,username FROM usuario WHERE username = '$usuario' ";
        return $this->select($sql);
    }
    public function eliminar($idUser)
    {
        $sql = "UPDATE usuario SET estado = ? WHERE id = ?";
        $array = array(0, $idUser);
        return $this->save($sql, $array);
    }
    public function getUsuario($idUser)
    {

        $sql = "SELECT * FROM usuario WHERE id = $idUser";
        return $this->select($sql);
    }

    public function getlogin($username)
    {
        $sql = "SELECT * FROM usuario WHERE username = $username";
        return $this->select($sql);
    }

    public function modificar($usuario, $password, $sistema, $personal_id, $estado, $rol_id, $id)
    {
        $sql = "UPDATE usuario SET username=?,password=?,sistema=?,personal_id=?,estado=? ,rol_id=?,updated_at = NOW()  WHERE id = ?";
        $array = array($usuario, $password, $sistema, $personal_id, $estado, $rol_id, $id);
        return $this->save($sql, $array);
    }

    public function registrarlog($usuario, $accion, $tabla, $detalles)
    {
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario, $accion, $tabla, $detalles);
        return $this->save($sql, $array);
    }

    public function modificarTrabajador($nombre, $apellido, $dni, $nacimiento, $direccion, $personal_id)
    {
        $sql = "UPDATE trabajador SET nombre=?,apellido=?,dni=?,fecha_nacimiento=?,rol_id=?,updated_at = NOW()  WHERE id = ?";
        $array = array($nombre, $apellido, $dni, $nacimiento, $direccion, $personal_id);
        return $this->save($sql, $array);
    }
}
