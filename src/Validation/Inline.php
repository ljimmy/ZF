<?php

namespace SF\Validation;

use SF\Support\PHP;


class Inline implements ValidatorInterface
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