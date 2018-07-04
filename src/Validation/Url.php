<?php

namespace SF\Validation;

use SF\Contracts\Validation\Validator;

class Url implements Validator
{

    public function validate($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }

}