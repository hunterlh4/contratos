<?php
class Conexion
{
    private $conect;
    public function __construct()
    {
        // $pdo = "pgsql:host=" . HOST . ";port=" . PUERTO . ";dbname=" . DB . ";options='--client_encoding=UTF8'";
        // $pdo1 = "pgsql:host=" . HOST . ";dbname=" . DB . ";" . CHARSET;
        // try {
        //     $this->conect = new PDO($pdo, USER, PASS);

        // $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // } catch (PDOException $e) {
        //     echo "Error en la conexion1" . $e->getMessage();
        // }



        // $mysqli = new mysqli(HOST, USER, PASS, DB, 3306);

        // if (mysqli_connect_errno()) {
        //     printf("Conexion fallida: %s\n", mysqli_connect_error());
        //     exit();
        // }
        // $mysqli->query("SET CHARACTER SET utf8");
        // $date = date("Y-m-d H:i:s");

        try {
            $dsn = "mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8";
            $this->conect = new PDO($dsn, USER, PASS);
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // echo "✅ Conexión a MySQL exitosa con PDO.<br>";
        } catch (PDOException $e) {
            die("❌ Error en la conexión con PDO: " . $e->getMessage());
        }
    }
    public function conect()
    {
        return $this->conect;
    }
}
