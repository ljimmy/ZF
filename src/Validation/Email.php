<?php

namespace SF\Validation;

use SF\Contracts\Validation\Validator;

class Email implements Validator
{

    public function validate($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
        return true;
    }

}