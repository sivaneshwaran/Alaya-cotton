<?php
// Dotenv code only
// Enable detailed error reporting for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    require __DIR__ .'\..\vendor\autoload.php';
    use Dotenv\Dotenv;

    if(!isset($GLOBALS['__ENV_LOADED'])){
        $dotenv = dotenv::createImmutable(__DIR__.'\..\private');
        $dotenv->load();
        $GLOBALS['__ENV_LOADED'] = true;
    }

?>