<?php

namespace SF\Protocol;


abstract class Message
{
    public abstract function getHeader();

    public abstract function getBody();
}