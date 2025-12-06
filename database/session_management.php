<?php 
// Class for session management
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
        $_SESSION["logged-in"] = true;
        $_SESSION["user_name"] = $user_data["client_name"];
        $_SESSION["id"] = $user_data["client_id"];
    }

// Logout session method
    public function logout(){
        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie("Alaya_Cottons", "", time()-4200, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_unset();
        session_destroy();
    }


    public function checkSession(){
        if(isset($_SESSION["logged-in"]) && $_SESSION["logged-in"] === true){
            return true;
        }
        return false;
    }

}

?>