<?php

namespace SF\Validation;


class Regexp implements ValidatorInterface
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