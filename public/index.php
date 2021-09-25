<?php

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$dbc = App\Foundation\DatabaseConnection::getConnection();
$routes = require_once __DIR__.'/../routes/web.php';

$router = new App\Foundation\Router($routes);

try {
    $route = $router->getMatchedRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (\Exception $e) {
    return require_once __DIR__.'/../views/404.php';
}

call_user_func_array([$route->getController(), $route->getMethod()], $route->getArguments($_SERVER['REQUEST_URI']));