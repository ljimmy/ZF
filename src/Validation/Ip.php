<?php

namespace SF\Validation;


class Ip implements ValidatorInterface
{
    public $ipv4 = false;

    public $ipv6 = false;


    public function validate($value)
    {
        $flag = 0;
        if ($this->ipv4) {
            $flag |= FILTER_FLAG_IPV4;
        }

        if ($this->ipv6) {
            $flag |= FILTER_FLAG_IPV6;
        }

        if (filter_var($value, FILTER_VALIDATE_IP, $flag) === false) {
            return false;
        }
        return true;
    }
}