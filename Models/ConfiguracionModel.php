<?php
class ConfiguracionModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getConfiguraciones()
    {
        $sql = "SELECT * from Configuracion ORDER BY id ASC";

        return $this->selectAll($sql);
    }
    public function getConfiguracion($id)
    {
        $sql = "SELECT * FROM Configuracion WHERE id = $id";
        return $this->select($sql);
    }
    public function verificar($api_1,$api_2)
    {
        $sql = "SELECT id,nombre FROM Configuracion WHERE api_1 = '$api_1' or api_2 = '$api_2' ";
        return $this->select($sql);
    }
    public function registrar($api_1, $api_2)
    {
        $sql = "INSERT INTO Configuracion (api_1,api_2) VALUES (?,?)";
        $array = array($api_1,$api_2);
        return $this->insertar($sql, $array);
    }
    public function modificar($api_1,$api_2,$id)
    {
        $sql = "UPDATE Configuracion SET api_1=?,api_2=? ,update_at = NOW()  WHERE id = ?";
        $array = array($api_1,$api_2, $id);
        return $this->save($sql, $array);
    }

    
    public function registrarlog($usuario,$accion,$tabla,$detalles){
        $sql = "INSERT INTO log (usuario_id,tipo_accion,tabla_afectada,detalles) VALUES (?,?,?,?)";
        $array = array($usuario,$accion,$tabla,$detalles);
        return $this->save($sql, $array);
    }
}
