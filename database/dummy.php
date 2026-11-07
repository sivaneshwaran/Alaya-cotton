<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Functions</title>

    <!-- Link for Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

<!-- Script for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    
</head>
<body>
    <?php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        require_once __DIR__."/../config/bootstrap.php";
        require_once __DIR__."/db_connection.php";
        require_once __DIR__."/cart_db.php";  
        require_once __DIR__."/product_database.php";
        require_once __DIR__.'/session_management.php';

        $db_conn = new db_connection();
        $pdo = $db_conn -> get_connection();
        $session = new session_management($pdo);

        $product_db = new product_db($pdo);

        $client_id = "";
        $client_name = "";
        $add_action_status = 0;
        $remove_status = false;
        $quantity = ['quantity' => 0];

        if($session -> checkSession()) {
            $client_id = $_SESSION["user_id"];
            $client_name = $_SESSION["user_name"];

            $cart_db = new cart_db($pdo, $client_id, $client_name);
            
            
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                if(isset($_POST['addProduct'])) {
                    $add_action_status = $cart_db -> addProduct(1, "Kondattam Copper Tissue Shirt & Gold Jari Border Dhoti Set", 1500, '1769680087_227c18ceb954.png');
                    $_POST = [];
                }
                if (isset($_POST['removeProduct'])) {
                    $remove_status = $cart_db -> remove(1);
                }

                if (isset($_POST['getQuantity'])) {
                    $quantity = $cart_db -> getQuantity(1);
                }

                if (isset($_POST['increase'])) {
                    $increased = $cart_db -> increaseQuantity(1);
                }

                if (isset($_POST['decrease'])) {
                    $increased = $cart_db -> decreaseQuantity(1);
                }
            }
        } else {
            echo "Session not Active please login";
        }


    ?>

    <div class="container-fluid bg-warning w-100">
        <?php
            if(isset($cart_db)) {
                echo "Cart db activated";
            } else {
                echo "Cart db not Activated";
            }
        ?>
        <form action="" method="post">
            <button class="addBtn btn btn-success" name="addProduct">Add</button>
            <button class="removeBtn btn btn-success" name="removeProduct">Remove</button>
            <button class="getQuantityBtn btn btn-success" name="getQuantity">Get Quantity</button>
            <button class="increaseQuantity btn btn-success" name="increase">increase Quantity</button>
            <button class="decreaseQuantity btn btn-success" name="decrease">decrease Quantity</button>

        </form>
            <button class="fetch btn btn-success" name="fetch">Fetch</button>

        <div class="status">
            <?php 
                if($add_action_status == 0) {
                    echo "Not Added </br>";
                } elseif ($add_action_status == 1) {
                    echo "Added </br>";
                } elseif ($add_action_status == 2) {
                    echo "Already present </br>";
                } else {
                    echo "Something went wrong </br>";
                }

                if($remove_status === true) {
                    echo "Product removed </br>";
                } elseif ($remove_status === false) {
                    echo "Product not removed </br>";
                }

                if ($quantity !== false) {
                    echo "Product Quantity is = $quantity[quantity] </br>";
                    var_dump($quantity);
                } else {
                    echo "product not found";
                }
            ?>
        </div>
        <div class="data container-fluid bg-danger">
            hello
        </div>
    </div>

    <script src="/./js/cart.js"></script>

</body>
</html>