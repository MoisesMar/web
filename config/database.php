<?php

class Database {

    private $hostname = "localhost";
    private $database = "tienda_online";
    private $username = "root";
    private $password = "admin201019";
    private $charset  = "utf8";

    function conectar() {
        try{
        $conexion = "mysql:host=" . $this->hostname . "; dbname=" .$this->database . "; 
        charset=" . $this->charset;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        $pdo = new PDO($conexion, $this->username, $this->password, $options);
        
        return $pdo;      
        
        } catch(PDOException $e) {
            echo 'Error conexion: ' . $e->getMessage();
            exit; //comentar esta línea
        }

    }

}

?>