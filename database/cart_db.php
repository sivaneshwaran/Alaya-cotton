<?php
class cart_db {
    private PDO $pdo;
    private $pdo_error = "";
    private ?string $client_id = "";
    private ?string $client_name = "";
    private $db_name = "card_table";

    public function __construct(PDO $pdo, string $client_id, string $client_name) {
        $this -> pdo = $pdo;
        $this -> client_id = $client_id;
        $this -> client_name = $client_name;
    }

// Adds the product to wishlist (return type: int ? 0=> Not added, 1=> Added, 2=> Already present)
    public function addProduct(string $product_id, string $product_name, string $price, string $thumbImg) {
        $query = "INSERT INTO $this->db_name(client_id, client_name, product_id, product_name, price, quantity, thumbImg) VALUES(:client_id, :client_name, :product_id, :product_name, :price, 1, :thumbImg)";

        try {
            if ($this->checkProduct($product_id)) {
                return 2;
            } else {
                $statement = $this->pdo->prepare($query);
                $statement->execute([
                    ":client_id" => $this->client_id,
                    ":client_name" => $this->client_name,
                    ":product_id" => $product_id,
                    ":product_name" => $product_name,
                    ":price" => $price,
                    ':thumbImg' => $thumbImg
                ]);

                return 1;      
            }      

        } catch (Exception $e) {
            $this -> pdo_error = $e -> getMessage();
            return 0;
        }
    }

// Removes the product from wishlist (return type: Boolean ? True=>Product removed, False=>Product not removed)
    public function remove(string $product_id){
        $query = "DELETE FROM $this->db_name WHERE client_id = :client_id AND product_id = :product_id";

        try{
            $statement = $this->pdo->prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id
            ]);

            return true;
        }  catch(PDOException $e){
            $this->pdo_error = $e->getMessage();
            return false;
        }
    }

// Check presence of product in wishlist (return type: Boolean ? True=> Present, False=> Absent)
    public function checkProduct(string $product_id){
        try{
            $query = "SELECT * FROM $this->db_name WHERE client_id = :client_id AND product_id = :product_id";

            $statement = $this->pdo->prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id
            ]);

            if($statement->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            $this->pdo_error = $e->getMessage();
            return false ;
        }
    }    

// Count the number of wishlist product
    public function count_product() {
        $list = $this->getlist();

        return count($list ?? []);
    }


// Get all Product (return type: Array ? array with all data)
    public function getlist(){
        try{
            $query = "SELECT product_id, product_name, price, quantity, thumbImg FROM $this->db_name WHERE client_id = :client_id";

            $statement = $this->pdo -> prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id
            ]);

            return $statement->fetchAll();
        }catch(PDOException $e){
            $this->pdo_error = $e->getMessage();
            return null;
        }

    }

// Get single product from Add to cart table by using product id
    public function getSingleProduct (string $product_id) {
        $query = "SELECT * FROM $this->db_name WHERE client_id = :client_id AND product_id = :product_id";

        try {
            $statement = $this->pdo -> prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id,
            ]);

            return $statement -> fetchAll();
        } catch (Exception $e) {
            $this->pdo_error = $e->getMessage();
            return null;
        }
    }

    public function getQuantity(string $product_id) {
        $query = "SELECT quantity FROM $this->db_name WHERE client_id = :client_id AND product_id = :product_id";

        try {
            $statement = $this->pdo -> prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id
            ]);

            return $statement -> fetch();
        } catch (Exception $e) {
            $this->pdo_error = $e -> getMessage();
            return false;
        }
    }

    public function increaseQuantity (string $product_id) {
        $query = "UPDATE $this->db_name SET quantity = quantity + 1 WHERE client_id = :client_id AND product_id = :product_id";

        try {
            $statement = $this->pdo -> prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id,
            ]);

            return true;
        } catch (Exception $e) {
            $this->pdo_error = $e -> getMessage();
            return false;
        }
    }
    
    public function decreaseQuantity (string $product_id) {
        $query = "UPDATE $this->db_name SET quantity = quantity - 1 WHERE client_id = :client_id AND product_id = :product_id";

        try {
            $statement = $this->pdo -> prepare($query);
            $statement -> execute([
                ":client_id" => $this->client_id,
                ":product_id" => $product_id,
            ]);

            return true;
        } catch (Exception $e) {
            $this->pdo_error = $e -> getMessage();
            return false;
        }
    }
}
?>