<?php

// Creo la clase que gestionará el acceso a la base de datos
class Database {
    private static $instance = null; // Atributo estático para la instancia única
    private $connection; // Atributo para la conexión PDO
    
    // Constructor privado para evitar instanciación externa
    private function __construct() {
        $host = 'proyectocinesprint3-db-1'; //Nombre del contenedor de BD
        $dbname = 'cinema'; //Nombre de la base de datos
        $username = 'cinema'; //Usuario de la base de datos
        $password =  'cinema'; //Contraseña del usuario de la base de datos

        try {
            $this->connection = new
            PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION); //Crea un nuevo objeto PDO y establece el modo de error a excepción
        } catch (PDOException $e) {
            die("Error de conexión: " . $e -> getMessage());
        }
    }

    public static function getInstance () {
        if (self::$instance == null) {
            self::$instance = new Database(); //Instancia la clase si no lo está ya
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }


}