<?php

namespace SF\Contracts\Context;


interface Context
{
    public function enter();

    public function exitContext();
}