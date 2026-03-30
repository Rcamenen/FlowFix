<?php

session_start();
define('ROOT',dirname(__DIR__));

use Core\Router;
use Dotenv\Dotenv;

require ROOT.'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(ROOT);
$dotenv->load();

$AVAILABLES_ROUTES = include(ROOT."/Config/Routes.php");

$router = new Router($AVAILABLES_ROUTES);
$router->getController();

?>