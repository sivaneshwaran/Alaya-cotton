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
        echo "
        <script>
            console.log('inside open try');
        </script>
        "; 
        return true;
    }

// No special action needed for Session in DB management
    public function close():bool{
        return true;
    }

// Read the session data stored in DB
    public function read(string $id): string|false{
                    echo "
        <script>
            console.log('inside read try');
        </script>
        ";      
        $query = "SELECT * FROM {$this->table} WHERE session_id = :session_id";
        $this->msg("r af q");
        try{
            $statement = $this->pdo->prepare($query);
        $this->msg("r af pre");

            $statement->execute([
                ":session_id"=> $id
            ]);
        $this->msg("r af exe");
        
            $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->msg("r af fet");

            return $row ? $row["user_data"]: "";

        }catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function write(string $id, string $data):bool{
        $this->msg("w bf tr");

        try{
            $query = "INSERT INTO {$this->table}(session_id, user_data, last_updated) VALUES(:session_id, :user_data, NOW()) ON DUPLICATE KEY UPDATE user_data = VALUES(user_data)  , last_updated = NOW()";
        $this->msg("w af q");
        
            $statement = $this->pdo->prepare($query);
        $this->msg("w af pre");
            $statement->execute([
                    ":session_id" => $id,
                    ":user_data" => $data,
                ]);
        $this->msg("w af exe");
                          
                return true;

        }catch(PDOException $e){
        $this->msg("w af catch");

            $this->error = $e->getMessage();
        $this->msg($e->getMessage());

            return false;
        }
    }

    public function destroy(string $id): bool{
            echo "
        <script>
            console.log('inside destroy try');
        </script>
        ";       
        try{
            $query = "DELETE FROM {$this->table} WHERE session_id = :id";
        $this->msg("d af q");

            $statement = $this->pdo->prepare($query);
        $this->msg("d af s");

        $statement -> execute([
                ":id" => $id
            ]);
        $this->msg("d af e");

                 
            return true;
        }catch(PDOException $e){
            $this->error = $e->getMessage();
        $this->msg($e->getMessage());
            
            return false;
        }
    }

    public function gc(int $max_lifetime): int|false{
            echo "
        <script>
            console.log('inside GC try');
        </script>
        ";            
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