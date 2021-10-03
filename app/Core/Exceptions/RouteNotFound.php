<?php
namespace App\Core\Exceptions;

class RouteNotFound extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
        parent::__construct();
    }
}