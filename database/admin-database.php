<?php
// Admin database connection php class
class admin_database{
    private PDO $pdo;
    private PDOException $e;
    private PDOException $conn_err;

    public function __construct(PDO $pdo)
    {
       try{
        $this->pdo = $pdo;
       }catch(PDOException $e){
            
       }
    }
}

?>