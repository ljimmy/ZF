<?php

namespace SF\Pool;

use SF\Context\ContextTrait;
use SF\Databases\ConnectorInterface;
use SF\Databases\DatabaseServiceProvider;

class DatabaseConnectPool extends AbstractPool
{

    use ContextTrait;

    public function release($connector)
    {
        if ($connector instanceof ConnectorInterface == false) {
            throw new PoolException('object is not an instance of ConnectorInterface.');
        }
        parent::release($connector);
    }

    /**
     * @return ConnectorInterface
     */
    protected function createConnector(): ConnectorInterface
    {
        return clone $this->getApplicationContext()->getContainer()->get(DatabaseServiceProvider::class)->getConnector();
    }

}
