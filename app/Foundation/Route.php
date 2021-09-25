<?php
namespace App\Foundation;

class Route
{
    private $requestMethod;
    private $pattern;    
    private $controller;
    private $method;
    
    public function __construct($requestMethod, $pattern, $controller, $method)
    {
        $this->requestMethod = $requestMethod;
        $this->pattern = '|^'.$pattern.'$|';;
        $this->controller = $controller;
        $this->method = $method;
    }

    public static function get($pattern, $controller,  $method) 
    {
        return new Route('GET', $pattern, $controller, $method);
    }

    public static function post($pattern, $controller, $method) 
    {
        return new Route('POST', $pattern, $controller, $method);
    }

    public static function put($pattern, $controller, $method) 
    {
        return new Route('PUT', $pattern, $controller, $method);
    }

    public static function patch($pattern, $controller, $method) 
    {
        return new Route('PATCH', $pattern, $controller, $method);
    }

    public static function delete($pattern, $controller, $method) 
    {
        return new Route('DELETE', $pattern, $controller, $method);
    }

    public function match($url, $requestMethod) 
    {
        if($this->requestMethod !== strtoupper($requestMethod)) {
            return false;
        }

        return (boolean) preg_match($this->pattern, $url);
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getArguments($url)
    {
        preg_match_all($this->pattern, $url, $matches);
        return $matches[1] ?? [];
    }
}