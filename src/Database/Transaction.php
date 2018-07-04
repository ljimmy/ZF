<?php

namespace SF\Database;

use SF\Contracts\Database\Connection;

class Transaction
{

    use ConnectionTrait;

    protected $connection;

    public function __construct(Connection $connection = null)
    {
        if ($connection === null) {
            $this->connection = self::getConnection();
        } else {
            $this->connection = $connection;
        }
    }

    /**
     * @param Statement $statement
     * @param array $params
     * @return ResultSet
     */
    public function execute(Statement $statement, array $params = []): ResultSet
    {
        return $statement->execute($this->connection, $params, false);
    }

    public function query(string $sql)
    {
        return $this->connection->query($sql);
    }


    public function commit()
    {
        try {
            $this->connection->commit();
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $this->connection->close();
        }
    }

    public function rollback()
    {
        try {
            $this->connection->rollback();
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $this->connection->close();
        }
    }

}
