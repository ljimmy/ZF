<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/1/26
 * Time: 下午7:06
 */

namespace SF\Validation;


class Boolean implements ValidatorInterface
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