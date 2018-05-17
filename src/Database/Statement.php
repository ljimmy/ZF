<?php

namespace SF\Database;

use SF\Contracts\Database\Statement as StatementInterface;
use SF\Contracts\Database\Connection as ConnectionInterface;
use SF\Contracts\Database\ResultSet as ResultSetInterface;

class Statement implements StatementInterface
{

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


    public function __construct(string $sql)
    {
        $this->sql        = $sql;
    }

    public function getSql(): string
    {
        return $this->sql;
    }

    public function getParams(): array
    {
        return $this->params;
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

    public function execute(ConnectionInterface $connection,array $params, bool $close = true): ResultSetInterface
    {
        $this->params = $params;
        $result = $connection->execute($this);
        $close && $connection->close();

        return $result;
    }

}
