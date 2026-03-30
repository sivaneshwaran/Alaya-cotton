<?php

class session_check{
// Checks the session presences
    public function checkSession(){
        $condition = isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] == true ;
        // isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true && session_name() === "Alaya_Cottons"
        var_dump($_COOKIE);
        if($condition){
            echo "
            <script> console.log('true');
            </script>
            ";
            return true;
        }
            echo "
            <script> console.log('false');
            </script>
            ";
        return false;
    }    
}

?>