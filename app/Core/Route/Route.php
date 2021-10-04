<?php
declare(strict_types=1);
namespace App\Core\Route;

use App\Http\Middleware\Interfaces\MiddlewareInterface;

class Route
{
    private string $requestMethod;
    private string $pattern;
    private string $controller;
    private string $method;
    private array $middlewares;

    public function __construct($requestMethod, $pattern, $controller, $method, $middlewares = [])
    {
        $this->requestMethod = $requestMethod;
        $this->pattern = '|^' . $pattern . '$|';;
        $this->controller = $controller;
        $this->method = $method;
        $this->middlewares = $middlewares;
    }

    public static function get($pattern, $controller,  $method, $middleware = []) : Route
    {
        return new Route('GET', $pattern, $controller, $method, $middleware);
    }

    public static function post($pattern, $controller, $method, $middleware = []) : Route
    {
        return new Route('POST', $pattern, $controller, $method, $middleware);
    }

    public static function put($pattern, $controller, $method, $middleware = []) : Route
    {
        return new Route('PUT', $pattern, $controller, $method, $middleware);
    }

    public static function patch($pattern, $controller, $method, $middleware = []) : Route
    {
        return new Route('PATCH', $pattern, $controller, $method, $middleware);
    }

    public static function delete($pattern, $controller, $method, $middleware = []) : Route
    {
        return new Route('DELETE', $pattern, $controller, $method, $middleware);
    }

    public function match($url, $requestMethod)
    {
        if ($this->requestMethod !== strtoupper($requestMethod)) {
            return false;
        }

        return (bool) preg_match($this->pattern, $url);
    }

    public function getControllerName()
    {
        return $this->controller;
    }

    public function getMethodName()
    {
        return $this->method;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    public function getArguments($url)
    {
        preg_match_all($this->pattern, $url, $matches);
        unset($matches[0]);
        $formatMatches = [];
        foreach ($matches as $key => $match) {
            $formatMatches[$key] = $match[0];
        }
        return $formatMatches;
    }
}
