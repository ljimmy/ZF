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
    private $myql;

    public function __construct(SwooleStatement $statement, string $sql, $myql = '')
    {
        $this->statement = $statement;
        $this->sql        = $sql;
        $this->myql = $myql;
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

        $resultSet = new ResultSet($result);

        $resultSet->affectedRows = $this->statement->affected_rows;
        $resultSet->insertId = $this->statement->insert_id;
        return $resultSet;
    }
}