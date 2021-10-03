<?php 

namespace app\core;

use App\Core\Route\Router;
use App\Core\Request\Request;
use App\Controllers\Controller;
use App\Core\DIContainer\Container;
use App\Core\Exceptions\RouteNotFound;

class App
{
    public static $rootDir;
    private $container;
    private $router;
    
    public function __construct($rootDir)
    {
        self::$rootDir = $rootDir;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    public function run() 
    {
        $request = new Request();

        try {
            $route = $this->router->getMatchedRoute($request->urlWithoutQuery(), $request->method());
            $controler = $this->container->make($route->getControllerName());
            $response = $this->callControllerMethod(
                $controler, 
                $route->getMethodName(),
                $route->getArguments($request->urlWithoutQuery())
            );
            return $this->render($response);
        } catch (RouteNotFound $e) {
            return $this->render([
                'path' => '404.twig', 
                'data' => ['message'=> $e->getMessage()]
            ]);
        }
    }

    private function render($response) 
    {
        $loader = new \Twig\Loader\FilesystemLoader(self::$rootDir.'/views/');
        $twig = new \Twig\Environment($loader, [
            // 'cache' =>  __DIR__.'/../storage/twig-cache',
        ]);
        echo $twig->render($response['path'], $response['data']);
    }

    private function callControllerMethod(Controller $controller, $method, $arguments) 
    {
        $abstractArguments = $this->container->getMethodAbstractArguments($controller, $method, $arguments);
        return call_user_func_array([$controller, $method], array_merge($arguments, $abstractArguments));
    }
}
?>