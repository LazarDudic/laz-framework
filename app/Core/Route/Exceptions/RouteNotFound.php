<?php
namespace App\Core\Route\Exceptions;

class RouteNotFound extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
        parent::__construct();
    }
}