<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/4
 * Time: 下午6:05
 */

namespace SF\Protocol;


interface VerifierInterface
{
    public function validate(string $credential);
}