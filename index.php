<?php
use Routes\Route;

require_once __DIR__ . '/vendor/autoload.php';
// require_once __DIR__ . '/src/Routes/Route.php';

$route = new Route();
$route->dispatch();
