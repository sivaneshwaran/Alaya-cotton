<?php 
class wishlist{
    private PDO $pdo;
    private $pdo_error = "";  
    private $client_id = null;
    private $client_name = null;

// Constructor 
    public function __construct(PDO $pdo, $client_id, $client_name){
        $this->pdo = $pdo;
        $this->client_id = $client_id;
        $this->client_name = $client_name;
    }

// Count the number of wishlist product
    public function count_product(){
        $list = $this->getlist();

        return count($list);
    }

// Check presence of product in wishlist (return type: Boolean ? True=> Present, False=> Absent)
    public function checkProduct($product_id){
        try{
            $query = "SELECT * FROM wishlist WHERE client_id = :client_id AND product_id = :product_id";

            $statement = $this->pdo->prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id
            ]);

            if($statement->rowCount() >0){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            $this->pdo_error;
            echo $e->getMessage();
            
            return false ;
        }
    }

// Adds the product to wishlist (return type: int ? 0=> Not add, 1=> Added, 2=> Already present)
    public function addProduct($product_id, $product_name){
        $query = "INSERT INTO wishlist(client_id, client_name, product_id, product_name) VALUES(:client_id, :client_name, :product_id, :product_name)";

        if($this->checkProduct($product_id)){
            return 2;
        }else{
            try{
                $statement = $this->pdo->prepare($query);
                $statement->execute([
                    ":client_id" => $this->client_id,
                    ":client_name" => $this->client_name,
                    ":product_id" => $product_id,
                    ":product_name" => $product_name
                ]);

                return 1;
            }catch(PDOException $e){
                $this->pdo_error = $e->getMessage();
                echo $this->pdo_error;
                return 0;
            }
        }
    }

// Removes the product from wishlist (return type: Boolean ? True=>Product removed, False=>Product not removed)
    public function remove($product_id){
        $query = "DELETE FROM wishlist WHERE client_id = :client_id AND product_id = :product_id";

        try{
            $statement = $this->pdo->prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id
            ]);

            return true;
        }catch(PDOException $e){
            $this->pdo_error = $e->getMessage();
            echo $this->pdo_error;
            return false;
        }
    }

// Get all Product (return type: Array ? array with all data)
    public function getlist(){
        try{
            $query = "SELECT * FROM wishlist WHERE client_id = :client_id";

            $statement = $this->pdo -> prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id
            ]);

            return $statement->fetchAll();
        }catch(PDOException $e){
            $this->pdo_error = $e->getMessage();
            echo $this->pdo_error;

            return false;
        }

    }
}
?>