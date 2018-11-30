<?php

namespace SF\Database;

class Query
{
    private $sql = '';

    private $params = [];

    public function __construct(string $sql, array $params = [])
    {
        $this->sql = $sql;
        $this->params = $params;
    }

    public function getSql():string
    {
        return $this->sql;
    }

    public function getParams():array
    {
        return $this->params;
    }

    public static function create(string $sql, array $params = []):Query
    {
        return new self($sql, $params);
    }

}
