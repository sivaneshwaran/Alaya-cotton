<?php 
require_once __DIR__."\..\config\bootstrap.php";
require_once __DIR__."\..\database\wishlist_db.php";
require_once __DIR__."\..\database\db_connection.php";
require_once __DIR__."\..\database\session_management.php";

// GET data from ajax
$product_id = htmlspecialchars($_POST["product_id"]);
$product_name = htmlspecialchars($_POST["product_name"]);
$action = htmlspecialchars($_POST["action"]);
if($_COOKIE["logged_in"] == "true"){
    $user_data = json_decode($_COOKIE["user_data"], true);
    echo $user_data["user_name"];
    echo "\nUser logged in";
    
    

}else{
    echo "Not Logged in ";
}
$session = new session_management();

foreach($_SESSION as $key => $values){
    echo "\nKey = ".$key."; Value = ".$values."\n";
}


// DB connection
$db_conn = new db_connection();
$pdo = $db_conn->get_connection();

// $wishlist = new wishlist($pdo, $user_data['user_id'], $user_data['user_name']);

// if(isset($action) & $action === "add"){
//     $res = $wishlist->addProduct($product_id, $product_name);
//     echo $res;
// }else if(isset($action) & $action === "remove"){
//     $wishlist->remove($product_id);
//     echo "removed";
// }else if(isset($action) & $action === "count"){
//     echo $wishlist->count_product();
// }




?>
