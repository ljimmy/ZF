<?php

namespace SF\Database\Connection\Swoole;

use SF\Coroutine\MySQL;
use SF\Exceptions\Database\SqlException;
use SF\Exceptions\Database\ConnectException;
use SF\Database\DriverPropertyInfo;
use SF\Contracts\Database\Connection as ConnectionInterface;
use SF\Contracts\Database\Statement as StatementInterface;

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
                'charset' => $this->info->charset,
                'fetch_mode' => true
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
        $statement = $this->mysql->prepare($sql);
        if ($statement === false) {
            throw new SqlException($this->mysql->error, $this->mysql->errno);
        }
        return new Statement($statement, $sql, $this);
    }

    public function begin(): bool
    {
        if ($this->isClosed()) {
            $this->connect();
        }
        return $this->mysql->begin() !== false;
//        return $this->query('START TRANSACTION') !== false;
    }

    public function commit(): bool
    {
        if ($this->isClosed()) {
            $this->connect();
        }
        return $this->mysql->commit() !== false;
//        return $this->query('COMMIT') !== false;
    }

    public function rollback(): bool
    {
        if ($this->isClosed()) {
            $this->connect();
        }
        return $this->mysql->rollback() !== false;
//        return $this->query('ROLLBACK') !== false;
    }

}
