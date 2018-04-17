<?php

namespace SF\Contracts\Protocol;


interface Receiver
{
    public function unpack(): Message;

}