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
                p.id as personal_id,
                p.dni as personal_dni,
                p.nombre AS personal_nombre,
                p.apellido_paterno AS personal_apellido_paterno, 
                 p.apellido_materno AS personal_apellido_materno, 
                 p.correo as personal_correo,
                
                a.id AS area_id, 
                a.nombre AS area_nombre, 
                c.id AS cargo_id, 
                c.nombre AS cargo_nombre,
                p.estado as personal_estado
              
                FROM Personal AS p 
                left JOIN area AS a ON p.area_id = a.id 
                left JOIN cargo AS C ON p.cargo_id = c.id
              
                ORDER BY p.id asc";
        // $sql = "SELECT T.id as tid,T.estado as testado from Personales as T ORDER BY id ASC";
        return $this->selectAll($sql);
    }

    public function getAllActivo()
    {


        $sql = "SELECT 
               id,nombre,estado,apellido_paterno
                FROM Personal 
                -- where estado = 1
                ORDER BY nombre asc ";
        // $sql = "SELECT T.id as tid,T.estado as testado from Personales as T ORDER BY id ASC";
        return $this->selectAll($sql);
    }

    public function getPersonal($id)
    {
        $sql = "SELECT * FROM Personal WHERE id = $id";

        return $this->select($sql);
    }

    public function listarAbogado()
    {
        $sql = "SELECT p.*, c.nombre AS cargo_nombre
FROM personal p
INNER JOIN cargo c ON p.cargo_id = c.id
WHERE c.nombre = 'Abogado' OR c.nombre ='Abogado Junior' 
ORDER BY p.apellido_paterno ;";
        return $this->selectAll($sql);
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
    public function registrar($dni, $nombre, $apellido_paterno, $apellido_materno, $area, $cargo, $correo, $telefono, $celular)
    {
        $sql = "INSERT INTO Personal (dni,nombre,apellido_paterno,apellido_materno,area_id,cargo_id,correo,telefono,celular) VALUES (?,?,?,?,?,?,?,?,?)";
        $array = array($dni, $nombre, $apellido_paterno, $apellido_materno, $area, $cargo, $correo, $telefono, $celular);
        return $this->insertar($sql, $array);
    }
    public function modificar($dni, $nombre, $apellido_paterno, $apellido_materno, $area, $cargo, $correo, $telefono, $celular, $estado, $id)
    {
        $sql = "UPDATE Personal SET dni=?,nombre=?,apellido_paterno=?,apellido_materno=?,area_id=?,cargo_id=?,correo=?,telefono=?,celular=?,estado=? WHERE id = ?";
        $array = array($dni, $nombre, $apellido_paterno, $apellido_materno, $area, $cargo, $correo, $telefono, $celular, $estado, $id);
        return $this->save($sql, $array);
    }

    public function registrarlog($usuario, $accion, $tabla, $detalles)
    {
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario, $accion, $tabla, $detalles);
        return $this->save($sql, $array);
    }
}
