<?php

define('ROOT',dirname(__DIR__));
use Core\Router;
use Dotenv\Dotenv;

require ROOT.'/vendor/autoload.php';
$dotenv = Dotenv::createImmutable(ROOT);
$dotenv->load();

$router = new Router();

?>