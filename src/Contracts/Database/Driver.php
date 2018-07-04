<?php

namespace SF\Contracts\Database;

interface Driver
{

    public function connect(): Connection;
}
