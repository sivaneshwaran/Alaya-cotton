<?php 
class session_handler implements SessionHandlerInterface{
    private PDO $pdo;
    private $error = null;
    private ?int $client_id = null;
    private $table = "user_session";
    

    public function __construct($PDO){
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
        $query = "SELECT * FROM {$this->table} WHERE session_id = :session_id";
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
            $query = "INSERT INTO {$this->table}(session_id, user_data, last_updated) VALUES(:session_id, :user_data, NOW()) ON DUPLICATE KEY UPDATE user_data = VALUES(user_data)  , last_updated = NOW()";
        
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                    ":session_id" => $id,
                    ":user_data" => $data,
                ]);
                          
                return true;

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            $this->msg($e->getMessage());
            return false;
        }
    }

    public function destroy(string $id): bool{  
        try{
            $query = "DELETE FROM {$this->table} WHERE session_id = :id";

            $statement = $this->pdo->prepare($query);

        $statement -> execute([
                ":id" => $id
            ]);
                 
            return true;
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            $this->msg($e->getMessage());
            
            return false;
        }
    }

    public function gc(int $max_lifetime): int|false{
        try{
            $query = "DELETE * FROM {$this->table} WHERE last_updated < NOW() - INTERVAL ? SECOND";

            $statement = $this->pdo->prepare($query);
            $statement->execute();
            
            return $statement -> rowCount();
            
        }catch(PDOException $e){
            $this->error = $e -> getMessage();
            return false;
        }
    }

    
}
?>