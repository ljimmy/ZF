<?php

namespace SF\Database\Pooling;


use SF\Contracts\Database\Connection as ConnectionInterface;
use SF\Contracts\Database\ResultSet;
use SF\Contracts\Database\Statement;
use SF\Pool\PooledConnection;

class Connection implements ConnectionInterface
{
    protected $pooledConnection;

    public function __construct(PooledConnection $pooledConnection)
    {
        $this->pooledConnection = $pooledConnection;
    }


    public function begin()
    {
        return $this->pooledConnection->begin();
    }

    public function commit()
    {
        return $this->pooledConnection->commit();
    }

    public function rollback(): bool
    {
        return $this->pooledConnection->rollback();
    }

    public function prepare(string $sql): Statement
    {
        return $this->pooledConnection->prepare($sql);
    }

    public function execute(Statement $statement): ResultSet
    {
        return $this->pooledConnection->execute($statement);
    }

    public function query(string $sql)
    {
        return $this->pooledConnection->query($sql);
    }

    public function close(): void
    {
        $this->pooledConnection->close();
        $this->pooledConnection = null;
    }

    public function isClosed(): bool
    {
        if ($this->pooledConnection === null) {
            return true;
        } else {
            return $this->pooledConnection->isClosed();
        }
    }


}