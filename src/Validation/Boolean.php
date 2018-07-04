<?php

namespace SF\Validation;

use SF\Contracts\Validation\Validator;

class Boolean implements Validator
{

    public $strict = false;

    public $trueValue = true;

    public function validate($value)
    {
        if ($this->strict) {
            return $value === $this->trueValue;
        } else {
            return $value == $this->trueValue;
        }
    }


}