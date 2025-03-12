<?php

class Conexion {
    private $host = "localhost";
    private $dbname = "trabajo";
    private $user = "root";
    private $pass = "";
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de la conexion: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->pdo;
    }
}


?>