<?php

namespace SF\Validation;


class Email implements ValidatorInterface
{


    public function validate($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
        return true;
    }

}