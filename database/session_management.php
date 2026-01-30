<?php 
// Class for session management for Clients only
class session_management{
// Class properties

// Class constructor for initiate the Session and its parameters
    public function __construct()
    {
    // Configure session cookie parameters
        session_set_cookie_params([
            'lifetime' => 3600*24,
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
        $user_data = $data;
        $_SESSION["logged_in"] = true;
        $_SESSION["user_type"] = "client";
        $_SESSION["user_name"] = $user_data["client_name"];
        $_SESSION["id"] = $user_data["client_id"];
    }

// Logout session method
    public function logout(){
        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie("Alaya_Cottons", " ", time()-4200, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_unset();
        session_destroy();
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

}

?>