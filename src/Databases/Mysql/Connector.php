<?php

namespace SF\Databases\Mysql;

use Swoole\Coroutine\Mysql;
use SF\Databases\Statement;
use SF\Databases\ResultSet;
use SF\Databases\SqlException;
use SF\Databases\ConnectorInterface;

class Connector implements ConnectorInterface
{

    /**
     *
     * @var string
     */
    public $host;

    /**
     *
     * @var int
     */
    public $port;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $database;

    /**
     *
     * @var int
     */
    public $timeout;

    /**
     *
     * @var string
     */
    public $charset;

    /**
     *
     * @var Mysql
     */
    private $client;

    /**
     *
     * @var bool
     */
    private $closed = false;

    public function __construct()
    {

    }

    public function init()
    {
        $this->client = new Mysql();
        $this->connect();
    }

    private function connect()
    {
        $result = $this->client->connect(
            [
                'host' => $this->host,
                'port' => $this->port,
                'user' => $this->username,
                'password' => $this->password,
                'database' => $this->database,
                'timeout' => $this->timeout,
                'charset' => $this->charset
            ]
        );
        if ($result === false) {
            throw new SqlException($this->client->connect_error, $this->client->connect_errno);
        }

        $this->closed = false;
    }

    public function execute(Statement $statement): ResultSet
    {
        if ($this->client === null) {
            $this->init();
        }

        for ($i = 0; $i < 2; $i++) {
            if ($this->client->prepare($statement->getSql()) == false) {
                if ($this->client->errno == 2006) {
                    $this->connect();
                    continue;
                }
                throw new SqlException($this->client->error, $this->client->errno);
            }
            break;
        }

        $resultSet = new ResultSet();
        $resultSet->setResult((array)$this->client->execute($statement->getParams()));
        $resultSet->affectedRows = $this->client->affected_rows;
        $resultSet->insertId = $this->client->insert_id;

        return $resultSet;
    }

    /**
     * @return mixed|void
     * @throws SqlException
     */
    public function begin()
    {
        return $this->query('START TRANSACTION');
    }

    /**
     * @return mixed|void
     * @throws SqlException
     */
    public function commit()
    {
        return $this->query('COMMIT');
    }

    /**
     * @return mixed|void
     * @throws SqlException
     */
    public function rollback()
    {
        return $this->query('ROLLBACK');
    }

    private function query(string $sql)
    {
        if ($this->client === null) {
            $this->init();
        }

        for ($i = 0; $i < 2; $i++) {
            if ($this->client->query($sql) == false) {
                if ($this->client->errno == 2006) {
                    $this->connect();
                    continue;
                }
                throw new SqlException($this->client->error, $this->client->errno);
            }
            break;
        }
    }

    public function __clone()
    {
        $this->client = null;
    }

}
