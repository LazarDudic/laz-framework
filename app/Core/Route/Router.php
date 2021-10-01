<?php

namespace App\Core\Route;

class Router
{
    private $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }
    public function getMatchedRoute($url, $requestMethod)
    {
        foreach ($this->routes as $route) {
            if ($route->match($url, $requestMethod) === true) {
                return $route;
            }
        }

        throw new \Exception('Route not Found');
    }
}
