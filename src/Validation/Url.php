<?php

namespace SF\Validation;


class Url implements ValidatorInterface
{
    public function validate($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }

}