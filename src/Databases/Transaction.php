<?php

namespace SF\Databases;

class Transaction
{

    use ConnectorTrait;

    public function __construct()
    {
        $this->getConnector()->begin();
    }

    /**
     * @param Statement $statement
     * @return ResultSet
     */
    public function execute(Statement $statement): ResultSet
    {
        return $this->getConnector()->execute($statement);
    }


    public function commit()
    {
        $this->getConnector()->commit();
        $this->release();
    }

    public function rollback()
    {
        $this->getConnector()->rollback();
        $this->release();
    }

}
