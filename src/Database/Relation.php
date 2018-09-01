<?php

namespace SF\Database;


use SF\Contracts\Database\Connection;
use SF\Contracts\Database\Statement;

class Relation
{

    private $sql;

    private $connection;

    public function __construct($sql, Connection $connection)
    {
        $this->sql = $sql;
        $this->connection = $connection;
    }

    public function getStatement(array $params = []): Statement
    {
        if ($this->sql instanceof \Closure) {
            $sql = ($this->sql)($params);
        } else {
            $sql = $this->sql;
        }
        return $this->connection->prepare($sql);
    }
}