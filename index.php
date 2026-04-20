<?php

session_start();
define('ROOT',__DIR__);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/errors.log');
error_reporting(E_ALL);

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