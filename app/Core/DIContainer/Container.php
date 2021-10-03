<?php
namespace App\Core\DIContainer;

use App\Controllers\Controller;


class Container
{
    protected $bind = [];

    public function bind($key, $value)
    {
        $this->bind[$key] = is_object($value) 
            ? $value
            : $this->build($value);
    }

    public function make($key)
    {
        if (!isset($this->bind[$key])) {
            $this->bind($key, $key);
        }
        return $this->bind[$key];
    }

    public function build($abstract)
    {
        $reflect = new \ReflectionClass($abstract);
        $constructor = $reflect->getConstructor();
        if (is_null($constructor)) {
            return $reflect->newInstance();
        }
        $instances = $this->getParameters($constructor);
        return $reflect->newInstanceArgs($instances);
    }

    public function getMethodAbstractArguments($abstract, $method)
    {
        $reflect = new \ReflectionClass($abstract);
        $method = $reflect->getMethod($method);

        return $this->getParameters($method);
    }

    protected function getParameters($method)
    {
        $parameters = $method->getParameters();

        $dependencies = [];
        foreach ($parameters as $parameter) {
            if($parameter->getClass()) {
                $dependencies[] = $this->make($parameter->getClass()->name);
            }
        }
        return $dependencies;
    }

}