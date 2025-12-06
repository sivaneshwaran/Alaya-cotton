<?php
class db_connection{
    private PDO $pdo;
    private $pdo_error;

    public function __construct(){
        $dns = "mysql::host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME'];
        $user =  $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try{
            $this->pdo = new PDO($dns, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }catch(PDOException $e){
            $this->pdo_error;
            throw new RuntimeException("Database connection failed: ". $e->getMessage());
        }
    }

    function get_connection():PDO{
        return $this->pdo;
    }

    function get_error(){
        return $this->pdo_error;
    }

}

?>