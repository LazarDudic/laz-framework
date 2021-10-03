<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = new App\Core\App(dirname(__DIR__));

$container = require_once __DIR__ . '/../bootstrap/container.php';
$app->setContainer($container);

$routes = require_once __DIR__ . '/../routes/web.php';
$router = new App\Core\Route\Router($routes);
$app->setRouter($router);


$app->run();

