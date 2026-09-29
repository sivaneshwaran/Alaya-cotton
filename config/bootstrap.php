<?php
// Dotenv code 
// Force GC to run on 100% of page loads (ONLY FOR TESTING)
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);

// PHP ini setup config
ini_set("session.gc_maxlifetime", "3600");
ini_set("session.lazy_write", 1);  // To avoid session data creation in DB for Not logged in users
// Enable detailed error reporting for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    require __DIR__ .'/../vendor/autoload.php';
    use Dotenv\Dotenv;

    if(!isset($GLOBALS['__ENV_LOADED'])){
        $dotenv = dotenv::createImmutable(__DIR__.'/../private', '.env');
        $dotenv->load();
        $GLOBALS['__ENV_LOADED'] = true;
    }

?>