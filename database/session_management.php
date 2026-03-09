<?php 
    require_once __DIR__."/session_handler.php";


// Class for session management for Clients only
class session_management{
// Class properties

// Class constructor for initiate the Session and its parameters
    public function __construct($pdo)
    {
    // Session handle code
        $handler = new session_handler($pdo);
        session_set_save_handler($handler, true);   

    // Configure session cookie parameters
        session_set_cookie_params([
            'lifetime' => 3600*24*7,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

    // Session name
        session_name("Alaya_Cottons");
    // Session start
        session_start();
    }

// Login session method
    public function login(array $data){
        // Session data
        $_SESSION["logged_in"] = true;
        $_SESSION["user_type"] = "client";  
        $_SESSION["user_name"] = $data["client_name"];
        $_SESSION["user_id"] = $data["client_id"];
        
        // cookie data
        setcookie("logged_in", "true", time()+ 3600*24, "/", "", true, true);
    }

// Logout session method
    public function logout(){
        session_unset();
        session_destroy();
        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie("Alaya_Cottons", "", time()-4200, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            setcookie("logged_in", "false",  time()+ 3600*24, "/", "", true, true);
        }

    }

// Checks the session presences
    public function checkSession(){
        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && session_name() === "Alaya_Cottons"){
            return true;
        }
        return false;
    }

// Used to set the message in session 
    public function setMessage($message, $msg_name){
        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && session_name() === "Alaya_Cottons"){
            $_SESSION[$msg_name] = $message;
            return true;
        }
        return false;
    }

// Set cookies
    public function setCookies(){

    }

}

?>