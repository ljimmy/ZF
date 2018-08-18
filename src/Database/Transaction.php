<?php

namespace SF\Database;

use SF\Contracts\Database\Connection;

class Transaction
{

    use ConnectionTrait;

    protected $connection;

    public function __construct()
    {
        $this->begin();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return ResultSet
     */
    public function execute(string $sql, array $params = []): ResultSet
    {
        $statement = $this->connection->prepare($sql);
        return $statement->execute($params);
    }

    public function query(string $sql)
    {
        return $this->connection->query($sql);
    }

    public function begin()
    {
        if ($this->connection === null) {
            $this->connection = self::getConnection();
        }

        $this->connection->begin();
    }



    public function commit()
    {
        try {
            $this->connection->commit();
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $this->close();
        }
    }

    public function rollback()
    {
        try {
            $this->connection->rollback();
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $this->close();
        }
    }

    protected function close()
    {
        $this->connection->close();
        $this->connection = null;
    }

}
