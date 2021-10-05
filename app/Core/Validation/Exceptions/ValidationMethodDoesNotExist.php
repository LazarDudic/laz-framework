<?php
namespace App\Core\Validation\Exceptions;

class ValidationRuleDoesNotExist extends \Exception
{
    public function __construct($message) {
        $this->message = $message;
        parent::__construct();
    }
}