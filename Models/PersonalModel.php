<?php
class PersonalModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getPersonales()
    {
        // $sql = "SELECT * from horario_detalle ORDER BY id ASC";
        // $sql = "SELECT * FROM horario_detalle WHERE horario_id = $id";

        $sql = "SELECT 
                T.id as tid,
                T.dni as tdni,
                T.apellido_nombre AS tnombre, 
                D.nombre AS dnombre, 
                C.nombre AS cnombre, 
                R.nombre AS rnombre, 
                T.estado as testado
              
                FROM Personal AS T 
                INNER JOIN direccion AS D ON T.direccion_id = D.id 
                INNER JOIN cargo AS C ON T.cargo_id = C.id
                INNER JOIN regimen AS R ON T.regimen_id = R.id
                ORDER BY T.id asc ";
        // $sql = "SELECT T.id as tid,T.estado as testado from Personales as T ORDER BY id ASC";
        return $this->selectAll($sql);
    }

    public function getAllActivo()
    {


        $sql = "SELECT 
               id,nombre,estado,apellido_paterno
                FROM Personal 
                where estado = 1
                ORDER BY id asc ";
        // $sql = "SELECT T.id as tid,T.estado as testado from Personales as T ORDER BY id ASC";
        return $this->selectAll($sql);
    }

    public function getPersonal($id)
    {
        $sql = "SELECT * FROM Personal WHERE id = $id";

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
        $sql = "SELECT 
                hd.id AS hdid,
                h.nombre AS hnombre,
                hd.nombre AS hdnombre, 
                to_char(hd.hora_entrada, 'HH24:MI') AS hora_entrada_sin_segundos, 
                to_char(hd.hora_salida, 'HH24:MI') AS hora_salida_sin_segundos, 
                hd.estado AS hdestado 
                FROM 
                    horario AS h 
                INNER JOIN 
                    horariodetalle AS hd 
                ON 
                    hd.horario_id = h.id 
                ORDER BY 
                    hd.id ASC;";
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
    public function verificar($dni)
    {
        $sql = "SELECT id,dni FROM Personal WHERE dni = '$dni' ";
        return $this->select($sql);
    }
    public function registrar($dni, $nombre, $apellido, $direccion_id, $regimen_id, $horarioDetalle_id, $cargo_id, $email, $telefono, $numero_tarjeta, $sexo, $fecha_nacimiento, $modalidad_trabajo)
    {
        $sql = "INSERT INTO Personal (dni,nombre,apellido,direccion_id,regimen_id,horarioDetalle_id,cargo_id,email,telefono,tarjeta,sexo,fecha_nacimiento,modalidad_trabajo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $array = array($dni, $nombre, $apellido, $direccion_id, $regimen_id, $horarioDetalle_id, $cargo_id, $email, $telefono, $numero_tarjeta, $sexo, $fecha_nacimiento, $modalidad_trabajo);
        return $this->insertar($sql, $array);
    }
    public function modificar($dni, $nombre, $apellido, $direccion_id, $regimen_id, $horarioDetalle_id, $cargo_id, $email, $telefono, $numero_tarjeta, $sexo, $fecha_nacimiento, $modalidad_trabajo, $estado, $id)
    {
        $sql = "UPDATE Personal SET dni=?,nombre=?,apellido=?,direccion_id=?,regimen_id=?,horarioDetalle_id=?,cargo_id=?,email=?,telefono=?,tarjeta=?,sexo=?,fecha_nacimiento=?,modalidad_trabajo=?,estado=? WHERE id = ?";
        $array = array($dni, $nombre, $apellido, $direccion_id, $regimen_id, $horarioDetalle_id, $cargo_id, $email, $telefono, $numero_tarjeta, $sexo, $fecha_nacimiento, $modalidad_trabajo, $estado, $id);
        return $this->save($sql, $array);
    }

    public function registrarlog($usuario, $accion, $tabla, $detalles)
    {
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario, $accion, $tabla, $detalles);
        return $this->save($sql, $array);
    }
}
