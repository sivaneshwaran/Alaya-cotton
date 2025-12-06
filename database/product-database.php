<?php
class product_db{
    private PDO $pdo;
    private $pdo_error = "";

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function createNewProduct($name, $category, $quantity, $buy_price, $sell_price, $description,array $original_names, array $unique_names, $staff_name, $staff_id){
        $name = $name;
        $category = $category;
        $quantity = $quantity;
        $buy_price = $buy_price;
        $sell_price = $sell_price;
        $description = $description;
        $staff_name = $staff_name;
        $staff_id = $staff_id;
        echo "<script> console.log('In method')</script>";

        try{
            $query = "INSERT INTO product_info(product_name, product_category, quantity, buy_price, sell_price, product_description, img1_name, img1_uniqname, img2_name, img2_uniqname, img3_name, img3_uniqname, img4_name, img4_uniqname, img5_name, img5_uniqname, staff_name, staff_id) values (:product_name, :product_category, :quantity, :buy_price, :sell_price, :product_description, :img1_name, :img1_uniqname, :img2_name, :img2_uniqname, :img3_name, :img3_uniqname, :img4_name, :img4_uniqname, :img5_name, :img5_uniqname, :staff_name, :staff_id)";

            $statement = $this->pdo->prepare($query);
            echo "<script> console.log('before execute')</script>";

            $statement -> execute([
                ':product_name' => $name,
                ':product_category' => $category,
                ':quantity' => $quantity, 
                ':buy_price' => $buy_price,
                ':sell_price' => $sell_price,
                ':product_description' => $description,
                ':img1_name' => $original_names[0], 
                ':img1_uniqname' => $unique_names[0], 
                ':img2_name' => $original_names[1], 
                ':img2_uniqname' => $unique_names[1], 
                ':img3_name' => $original_names[2], 
                ':img3_uniqname' => $unique_names[2], 
                ':img4_name' => $original_names[3], 
                ':img4_uniqname' => $unique_names[3], 
                ':img5_name' => $original_names[4], 
                ':img5_uniqname' => $unique_names[4],
                ':staff_name' => $staff_name,
                ':staff_id' => $staff_id
            ]);
        echo "<script> console.log('after execute')</script>";

            return true;    
        }catch(PDOException $e){
        echo "<script> console.log('Error')</script>";
            $this->pdo_error;
            echo $e->getMessage();
            
            return false;
        }
        
    }

}


?>