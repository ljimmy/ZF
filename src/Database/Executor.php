<?php

namespace SF\Database;

class Executor
{

    use ConnectorTrait;

    private $statement;

    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    public function execute(): ResultSet
    {
        $result = $this->getConnector()->execute($this->statement);
        $this->release();
        return $result;
    }

    public function __invoke()
    {
        return $this->execute();
    }

}
