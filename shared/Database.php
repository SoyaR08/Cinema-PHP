<?php

class Database {
    private static $instance = null;
    private $connection;
    private function __construct() {
        $host = 'proyectocinesprint3-db-1'; //Nombre del contenedor de BD
        $dbname = 'cinema';
        $username = 'cinema';
        $password =  'cinema';

        try {
            $this->connection = new
    PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e -> getMessage());
        }
    }

    public static function getInstance () {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }


}