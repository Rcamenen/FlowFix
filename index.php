<?php

session_start();
define('ROOT',__DIR__);

ini_set('display_errors', '0');
ini_set('log_errors', '0');
error_reporting(0);

use Core\Router;
use Dotenv\Dotenv;

include("Config/Config.php");

require ROOT.'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(ROOT);
$dotenv->load();

$AVAILABLES_ROUTES = include(ROOT."/Config/Routes.php");

$router = new Router($AVAILABLES_ROUTES);
$router->getController();

?>