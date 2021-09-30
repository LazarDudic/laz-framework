<?php
namespace App\Foundation\DIContainer;


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

    protected function getParameters($constructor)
    {
        $parameters = $constructor->getParameters();

        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependencies[] = $this->make($parameter->getClass()->name);
        }
        return $dependencies;
    }
}