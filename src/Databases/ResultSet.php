<?php

namespace SF\Databases;

class ResultSet implements \IteratorAggregate, \Countable
{

    /**
     *
     * @var int
     */
    public $affectedRows;

    /**
     *
     * @var int
     */
    public $insertId;

    /**
     *
     * @var array
     */
    private $rows = [];

    public function setResult(array $rows = [])
    {
        $this->rows = $rows;
    }

    public function getResult()
    {
        return $this->rows;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->rows);
    }

    public function count()
    {
        return count($this->resultSet);
    }

}
