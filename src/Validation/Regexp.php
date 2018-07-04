<?php

namespace SF\Validation;

use SF\Contracts\Validation\Validator;

class Regexp implements Validator
{

    public $pattern;

    public function validate($value)
    {
        if ($this->pattern === null) {
            return false;
        }
        return preg_match($value, $this->pattern);
    }


}