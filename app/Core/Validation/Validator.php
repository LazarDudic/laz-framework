<?php
namespace App\Core\Validation;

use App\Core\Validation\Exceptions\ValidationRuleDoesNotExist;

class Validator 
{
    protected $values;
    protected $errors = [];

    public function __construct(array $dataRules, array $values)
    {
        $this->values = $this->trim($values);
        foreach ($dataRules as $name => $rules) {
            if (array_key_exists($name, $values)) {
                foreach ($rules as $rule) {
                    if(!method_exists($this, $rule)) {
                        throw new ValidationRuleDoesNotExist('Validation rule '.$rule.' not found.');
                    }
                    $this->$rule($name);
                }
            }
        }
    }

    public function required($name) 
    {
        if (!isset($this->values[$name]) || empty($this->values[$name])) {
            $this->errors[$name][] = $name.' field is required'; 
        }
        return $this;
    }

    public function integer($name)
    {
        if (!is_int($this->values[$name])) {
            $this->errors[$name][] = $name.' field must be an integer.'; 
        }
        return $this;
    }

    public function number($name)
    {
        if (!is_numeric($this->values[$name])) {
            $this->errors[$name][] = $name.' field must be a number.'; 
        }
        return $this;
    }

    public function string($name)
    {
        if (!is_string($this->values[$name])) {
            $this->errors[$name][] = $name.' field must be a string.'; 
        }
        return $this;
    }

    public function email($name)
    {
        if (!filter_var($this->values[$name], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$name][] = $name.' field must be a valid email address.'; 
        }

        return $this;
    }

    public function isValid()
    {
        return count($this->errors) ? false : true;
    }

    public function errors()
    {
        return $this->errors;
    }

    protected function trim($values) 
    {
        $trim = [];
        foreach ($values as $name => $value) 
        {
            $trim[$name] = trim($value);
        }
        return $trim;
    }
}