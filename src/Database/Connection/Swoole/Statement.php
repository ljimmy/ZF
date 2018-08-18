<?php

namespace SF\Database\Connection\Swoole;

use SF\Exceptions\Database\SqlException;
use Swoole\Coroutine\Mysql\Statement as SwooleStatement;
use SF\Contracts\Database\Statement as StatementInterface;
use SF\Contracts\Database\ResultSet as ResultSetInterface;
use SF\Database\ResultSet;

class Statement implements StatementInterface
{
    public $timeout = -1;

    /**
     *
     * @var array
     */
    private $sql = '';

    /**
     *
     * @var array
     */
    private $params = [];

    /**
     * @var SwooleStatement
     */
    private $statement;


    public function __construct(SwooleStatement $statement, string $sql)
    {
        $this->statement = $statement;
        $this->sql        = $sql;
    }

    public function getRawSql(): string
    {
        if (empty($this->params)) {
            return $this->sql;
        }
        $sql = '';

        foreach (explode('?', $this->sql) as $i => $part) {
            $sql .= $part . ($this->params[$i] ?? '');
        }
        return $sql;
    }

    public function execute(array $params = []): ResultSetInterface
    {
        $this->params = $params;

        if ($this->statement->execute($params, $this->timeout) === false) {
            throw new SqlException($this->statement->error, $this->statement->errno);
        }

        $resultSet = new ResultSet($this->statement->fetchAll());

        $resultSet->affectedRows = $this->statement->affected_rows;
        $resultSet->insertId = $this->statement->insert_id;

        return $resultSet;
    }
}