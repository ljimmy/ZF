<?php

namespace SF\Validation;


class Mobile implements ValidatorInterface
{
    public $pattern = '/^1\d{10}$/';

    public function validate($value)
    {
        return preg_match($this->pattern, $value);
    }


}