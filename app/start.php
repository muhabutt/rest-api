<?php
ini_set('default_charset', 'UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST,GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Origin,Access-Control-Allow-Methods, Authrorization, X_Requested-With');

// Session cache false
//Session starts
session_cache_limiter(false);
session_start();

//Define aplication root directory to constant
define('INC_ROOT', dirname(__DIR__));

//Include all dependencies of our application
require_once INC_ROOT .'/vendor/autoload.php';

//load environment variables
$dotenv = Dotenv\Dotenv::createMutable(INC_ROOT );
$dotenv->load();

//convert all errors, warning, and notices into errors
function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}
set_error_handler("exception_error_handler");

//error reporting is off for production should be On for development
$env = \App\Config\Config::getValue('ENV');
if( $env == 'development'){
    ini_set('display_errors', 'On');
}else{
    ini_set('display_errors', 'Off');
}

$routes = new App\Core\Routes();







