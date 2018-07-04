<?php

namespace SF\Validation;

use SF\Support\PHP;
use SF\Contracts\Validation\Validator;

class Inline implements Validator
{

    /**
     * @var callable
     */
    public $callback;

    public function validate($value)
    {
        if ($this->callback === null) {
            return false;
        }

        return PHP::call($this->callback, [$value]) == true;
    }


}