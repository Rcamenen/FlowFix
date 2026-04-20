<?php

define('BASE_URL',str_replace("index.php",'',$_SERVER['PHP_SELF']));

define("FULL_URL", 
    ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')? "https://": "http://").$_SERVER['HTTP_HOST'].BASE_URL
);
?>