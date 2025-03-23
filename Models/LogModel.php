<?php
class LogModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getLogs()
    {
        $sql = "SELECT l.id 
        as log_id, u.username 
        as usuario,tipo_accion,tabla_afectada,detalles,l.create_at 
        as fecha 
        from log as l inner join usuario as u on u.id=l.usuario_id 
        ORDER BY l.id ASC";

        return $this->selectAll($sql);
    }

    public function getlog($id)
    {
        $sql = "SELECT detalles
        from log where id=$id";

        return $this->select($sql);
    }
  
}
