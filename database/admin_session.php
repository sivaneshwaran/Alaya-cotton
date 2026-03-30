<?php
// Session management for admin users
class admin_session{

// Constructor set the parameters for session for one day
    public function __construct()
    {
        session_set_cookie_params([
            'lifetime'=> 3600*24,
            'path'=> '/',
            'domain'=> '',
            'secure'=> true,
            'httponly' => true,
            'samesite'=> 'lax'
        ]);

    //Session name
        session_name('Admin_Alaya_cotton');

    // Session start
        session_start();
    }

// Function for login
    public function login(array $admin_data){
        $admin_data = $admin_data;
        $_SESSION['logged_in'] = true;
        $_SESSION['user-type'] = "admin";
        $_SESSION['staff_name'] = $admin_data['staff_name'];
        $_SESSION['staff_id'] = $admin_data['staff_id'];
    }

// Function for logout
    public function logout(){
        if(ini_get("session.use_cookies")){
            $param = session_get_cookie_params();
            setcookie("Admin_Alaya_cotton", "", time()-4200, $param["path"], $param["domain"], $param["secure"], $param["httponly"]);
        }
        session_unset();
        session_destroy();
    }

// Function for check session presence
    public function checkSession(){
        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && session_name() === "Admin_Alaya_cotton"){
            return true;
        }
        return false;
    }

// Used to set the message in session 
    public function setMessage($message, $msg_name){
        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && session_name() === "Admin_Alaya_cotton"){
            $_SESSION[$msg_name] = $message;
            return true;
        }
        return false;
    }

}


?>