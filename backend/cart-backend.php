<?php 
header("HTTP/1.1 200 OK");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-type: application/json');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Credentials: true');


require_once __DIR__."/../config/bootstrap.php";
require_once __DIR__."/../database/db_connection.php";
require __DIR__."/../database/session_management.php";
require __DIR__."/../database/cart_db.php";

$db_conn = new db_connection();
$pdo = $db_conn -> get_connection();

// Session object
$session = new session_management($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Bad Request: Wrong method call']);
    exit();
}

// input from request body
$rawData = file_get_contents('php://input'); 

// check request body data is empty or not
if (empty($rawData)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Bad request: Request body is empty']);
    exit();
}

// decode the json data into associtive array 
try {
    $postdata = json_decode($rawData, true, 512, JSON_THROW_ON_ERROR);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Bad request: Malformed json data received']);
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 'true' && isset($postdata['request']) && $postdata['request'] === 'cart') {
    // Cart Object
    $cart = new cart_db($pdo, $_SESSION['user_id'], $_SESSION['user_name']);

    if (isset($postdata['action']) && $postdata['action'] === 'fetch-cart') {
        try {
            $cart_items = $cart -> getlist();

            http_response_code(200);
            echo json_encode($cart_items);
            exit();
     
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internel server issue']);
            exit();
        }

    }

    if (isset($postdata['action']) && $postdata['action'] === 'increase-quantity') {
        try {
            $status = $cart -> increaseQuantity($postdata['product_id']);
            if ($status == false) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Server Issue: Can\'t change quantity']);
                // For clearing memory
                $cart = null;
                exit();
            } else {
                http_response_code(200);
                $quantity = $cart -> getQuantity($postdata['product_id']);
                echo json_encode(['success' => true, 'quantity' => $quantity['quantity']]);
                // For clearing memory
                $cart = null;                
                exit();
            }                
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internel server issue']);
            exit();
        }
    }

    if (isset($postdata['action']) && $postdata['action'] === 'decrease-quantity') {
        try {
            $status = $cart -> decreaseQuantity($postdata['product_id']);
            if ($status == false) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Server Issue: Can\'t change quantity']);
                // For clearing memory
                $cart = null;
                exit();
            } else {
                http_response_code(200);
                $quantity = $cart -> getQuantity($postdata['product_id']);
                echo json_encode(['success' => true, 'quantity' => $quantity['quantity']]);
                // For clearing memory
                $cart = null;                
                exit();
            }                
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internel server issue']);
            exit();
        }
    }

    if (isset($postdata['action']) && $postdata['action'] === 'remove-product') {
        try {
            $status = $cart -> remove($postdata['product_id']);
            if ($status == false) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Server Issue: Can\'t remove product']);
                // For clearing memory
                $cart = null;
                exit();
            } else {
                http_response_code(200);
                $quantity = $cart -> count_product();
                echo json_encode(['success' => true, 'product_count' => $quantity]);
                // For clearing memory
                $cart = null;                
                exit();
            }                
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internel server issue']);
            exit();
        }
    }

} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

?>