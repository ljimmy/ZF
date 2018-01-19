<?php

namespace SF\Databases;

class Statement
{
    /**
     *
     * @var array
     */
    private $sql;

    /**
     *
     * @var array
     */
    private $params = [];

    public function __construct(string $sql, array $params = [])
    {
        $this->sql    = $sql;
        $this->params = $params;
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function getParams()
    {
        return $this->params;
    }

}
