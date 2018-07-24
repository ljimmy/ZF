<?php

namespace SF\Database\Connection;

use SF\Coroutine\MySQL;
use SF\Database\ResultSet;
use SF\Database\Statement;
use SF\Exceptions\Databases\SqlException;
use SF\Database\DriverPropertyInfo;
use SF\Contracts\Database\Connection as ConnectionInterface;
use SF\Contracts\Database\Statement as StatementInterface;
use SF\Contracts\Database\ResultSet as ResultSetInterface;

class MysqlConnection implements ConnectionInterface
{

    private $mysql;

    /**
     * @var DriverPropertyInfo
     */
    private $info;


    public function __construct(DriverPropertyInfo $info)
    {
        $this->info = $info;
        $this->mysql = new MySQL();
    }

    protected function connect()
    {
        $config =
            [
                'host' => $this->info->host,
                'port' => $this->info->port ? $this->info->port : 3306,
                'user' => $this->info->username,
                'password' => $this->info->password,
                'database' => $this->info->database,
                'charset' => $this->info->charset
            ];

        $result = $this->mysql->connect(
            array_merge($config, $this->info->options)
        );

        if ($result === false) {
            throw new ConnectException($this->mysql->connect_error, $this->mysql->connect_errno);
        }
    }


    public function close(): void
    {
        $this->mysql->close();
    }

    public function isClosed(): bool
    {
        return $this->mysql->connected == false;
    }

    public function query(string $sql)
    {
        if ($this->isClosed()) {
            $this->connect();
        }

        $result = $this->mysql->query($sql);

        if ($result === false) {
            throw new SqlException($this->mysql->error, $this->mysql->errno);
        }

        return $result;
    }

    public function prepare(string $sql): StatementInterface
    {
        if ($this->isClosed()) {
            $this->connect();
        }

        if ($this->mysql->prepare($sql) === false) {
            throw new SqlException($this->mysql->error, $this->mysql->errno);
        }
        return new Statement($sql);
    }

    public function execute(StatementInterface $statement): ResultSetInterface
    {
        $resultSet = new ResultSet((array)$this->mysql->execute($statement->getParams()));

        $resultSet->affectedRows = $this->mysql->affected_rows;
        $resultSet->insertId = $this->mysql->insert_id;

        return $resultSet;
    }

    public function begin(): bool
    {
        return $this->query('START TRANSACTION') !== false;
    }

    public function commit(): bool
    {
        return $this->query('COMMIT') !== false;
    }

    public function rollback(): bool
    {
        return $this->query('ROLLBACK') !== false;
    }

}
