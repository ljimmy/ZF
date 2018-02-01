<?php
namespace SF\Context;


interface InterfaceContext
{
    public function enter();

    public function exitContext();
}