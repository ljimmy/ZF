<?php

namespace SF\Validation;

use SF\Contracts\Validation\Validator;

class Integer implements Validator
{

    public $min;

    public $max;

    public $message;

    public $tooBig;

    public $tooSmall;

    public function validate($value)
    {
        if (!is_numeric($value)) {
            return false;
        }

        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return false;
        }

        if ($this->min !== null && $value < $this->min) {
            $this->tooSmall !== null && $this->message = $this->tooSmall;
            return false;
        }

        if ($this->max !== null && $value > $this->max) {
            $this->tooBig && $this->message = $this->tooBig;
            return false;
        }

        return true;
    }


}