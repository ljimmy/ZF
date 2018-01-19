<?php

namespace SF\Databases;

use SF\Context\ContextTrait;

trait ConnectorTrait
{
    use ContextTrait;

    /**
     *
     * @var DatabaseServiceProvider
     */
    private $databaseServiceProvider;

    /**
     *
     * @var ConnectorInterface
     */
    private $connector;

    public function getDatabaseServiceProvider()
    {
        if ($this->databaseServiceProvider === null) {
            $this->databaseServiceProvider = $this->getApplicationContext()->getContainer()->get(DatabaseServiceProvider::class);
        }
        return $this->databaseServiceProvider;
    }

    public function getConnector(): ConnectorInterface
    {
        if ($this->connector === null) {
            $databaseServiceProvider = $this->getDatabaseServiceProvider();

            $this->connector = $databaseServiceProvider->pool === null ?
                $databaseServiceProvider->getConnector() :
                $databaseServiceProvider->getPool()->get();
        }
        return $this->connector;
    }

    public function release()
    {
        if ($this->connector === null) {
            return true;
        }

        if ($this->getDatabaseServiceProvider()->pool !== null) {
            $this->getDatabaseServiceProvider()->getPool()->release($this->connector);
        }
        $this->connector = null;
        return true;
    }

}
