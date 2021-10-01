<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = require_once __DIR__ . '/../bootstrap/container.php';
$routes = require_once __DIR__ . '/../routes/web.php';
$router = new App\Core\Route\Router($routes);
$path = strtok($_SERVER["REQUEST_URI"], '?');
try {
    $route = $router->getMatchedRoute($path, $_SERVER['REQUEST_METHOD']);
} catch (\Exception $e) {
    return require_once __DIR__ . '/../views/404.twig';
}

$controlerName = $route->getControllerName();
$controler = $container->make($controlerName);
$response = $container->callControllerMethod(
    $controler, 
    $route->getMethodName(),
    $route->getArguments($path)
);

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views/');
$twig = new \Twig\Environment($loader, [
    // 'cache' =>  __DIR__.'/../storage/twig-cache',
]);
echo $twig->render($response['path'], $response['data']);

