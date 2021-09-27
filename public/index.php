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
    return require_once __DIR__.'/../views/404.twig';
}

$controlerName = $route->getControllerName();
$controler = new $controlerName($dbc);
$response = call_user_func_array([$controler, $route->getMethodName()], $route->getArguments($_SERVER['REQUEST_URI']));

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views/');
$twig = new \Twig\Environment($loader, [
    'cache' =>  __DIR__.'/../storage/twig-cache',
]);
echo $twig->render($response['path'], $response['data']);
