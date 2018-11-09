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
     * @var string
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

    /**
     * @var
     */
    private $mysql;

    public function __construct(SwooleStatement $statement, string $sql, $mysql = '')
    {
        $this->statement = $statement;
        $this->sql        = $sql;
        $this->mysql = $mysql;
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
        $result = $this->statement->execute($params, $this->timeout);
        if ( $result === false) {
            throw new SqlException($this->statement->error, $this->statement->errno);
        }

        if (!is_array($result)) {
            $result = [];
        }

        $resultSet = new ResultSet($result);

        $resultSet->affectedRows = $this->statement->affected_rows;
        $resultSet->insertId = $this->statement->insert_id;
        return $resultSet;
    }

    public function __destruct()
    {
        $this->statement = null;
        $this->mysql = null;
    }
}