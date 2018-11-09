<?php
namespace SF\Database\Pooling;

use SF\Contracts\Database\ResultSet;
use SF\Contracts\Database\Statement as StatementInterface;


class Statement implements StatementInterface
{
    private $connection;

    private $statement;

    public function __construct(Connection $connection, StatementInterface $statement)
    {
        $this->connection = $connection;
        $this->statement = $statement;
    }

    public function getRawSql(): string
    {
        return $this->statement->getRawSql();
    }

    public function execute(array $params = []): ResultSet
    {
        return $this->statement->execute($params);
    }

    public function __destruct()
    {
        $this->statement = null;
        $this->connection = null;
    }


}