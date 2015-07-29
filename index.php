<?php
session_start();
session_regenerate_id(true); //Trying to prevent session hijacking

define("BASE_PATH", implode("/", array_slice(explode('/', $_SERVER['SCRIPT_NAME']),0,-1)));
define("BASE_DIR", dirname(__FILE__));

require_once BASE_DIR.'/System/Autoload.php';

$autoload = new Autoload(BASE_DIR, array("System", "Models", "Views", "Controllers"));
$router = new Router();
$mainController = new MainController($router, $router->baseRoute, $router->action, $router->errorException);
echo $mainController->output();
?>
