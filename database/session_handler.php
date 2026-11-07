<?php 
class session_handler implements SessionHandlerInterface{
    private PDO $pdo;
    private $error = null;
    private ?int $client_id = null;
    private $table = "user_session";
    

    public function __construct(PDO $PDO){
        $this->pdo = $PDO;
    }

    public function msg(string $msg){
        echo "
        <script>
            console.log('$msg');
        </script>
        ";
    }

// No special action needed for Session in DB management
    public function open(string $savepath, string $sessionName) : bool{
        return true;
    }

// No special action needed for Session in DB management
    public function close():bool{
        return true;
    }

// Read the session data stored in DB
    public function read(string $id): string|false{   
        $query = "SELECT * FROM $this->table WHERE session_id = :session_id";
        try{
            $statement = $this->pdo->prepare($query);

            $statement->execute([
                ":session_id"=> $id
            ]);
        
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            return $row ? $row["user_data"]: "";

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function write(string $id, string $data):bool{

        try{
            $query = "INSERT INTO $this->table(session_id, user_data, last_updated) VALUES(:session_id, :user_data, NOW()) ON DUPLICATE KEY UPDATE user_data = VALUES(user_data), last_updated = NOW()";

            if (!empty($data)) {     
                $statement = $this->pdo->prepare($query);
                $statement->execute([
                    ":session_id" => $id,
                    ":user_data" => $data,
                ]);
            } else {
                return true;
            }
            return true;

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function destroy(string $id): bool{  
        try{
            $query = "DELETE FROM $this->table WHERE session_id = :id";

            $statement = $this->pdo->prepare($query);

        $statement -> execute([
                ":id" => $id
            ]);
                 
            return true;
        }catch(PDOException $e){
            $this->error = $e->getMessage();            
            return false;
        }
    }

    public function gc($max_lifetime): int|false{
        try{
            // $query = "DELETE * FROM $this->table WHERE last_updated < DATE_SUB(NOW() - INTERVAL :max_lifetime SECOND)";
            $expiry = time()-$max_lifetime;
            $query = "DELETE * FROM $this->table WHERE last_updated < :expiry";

            $statement = $this->pdo->prepare($query);
            $statement->execute([
                ":expiry" => $expiry
            ]);
            
            return $statement -> rowCount();
            
        }catch(PDOException $e){
            $this->error = $e -> getMessage();
            return false;
        }
    }

    
}
?>