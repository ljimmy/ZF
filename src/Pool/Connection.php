<?php

namespace SF\Pool;


class Connection
{
    private $connection;

    private function __construct($connection)
    {
        $this->connection = $connection;
    }


    private function __clone()
    {

    }

    public function __get($name)
    {
        return $this->connection->$name;
    }


    public static function wrapper(string $connection)
    {

    }

}