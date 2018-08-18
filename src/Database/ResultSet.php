<?php

namespace SF\Database;

use SF\Contracts\Database\ResultSet as ResultSetInterface;

class ResultSet implements \IteratorAggregate, \Countable, ResultSetInterface
{

    /**
     *
     * @var int
     */
    public $affectedRows = 0;

    /**
     *
     * @var int
     */
    public $insertId = 0;

    /**
     *
     * @var array
     */
    private $rows = [];

    public function __construct(array $rows = null)
    {
        $this->rows = $rows === null ? [] : $rows;
    }

    public function first()
    {
        if (empty($this->rows)) {
            return null;
        }

        return reset($this->rows);
    }

    public function field(string $name = null)
    {
        $one = current($this->rows);

        if (empty($one)) {
            return null;
        }

        if (!is_array($one)) {
            return $one;
        }

        return $name === null ? current($one) : $one[$name];
    }

    public function get(string $column): array
    {
        return array_column($this->rows, $column);
    }

    public function getLastInsertId(): int
    {
        return $this->insertId;
    }

    public function getAffectedRows(): int
    {
        return $this->affectedRows;
    }

    public function getResult(): array
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
