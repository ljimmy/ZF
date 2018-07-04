<?php

namespace SF\Validation;

use SF\Contracts\Validation\Validator;

class Mobile implements Validator
{

    public $pattern = '/^1\d{10}$/';

    public function validate($value)
    {
        return preg_match($this->pattern, $value);
    }


}