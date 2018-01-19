<?php

namespace SF\Databases;

interface ConnectorInterface
{

    public function execute(Statement $statement): ResultSet;

    /**
     * begin transaction
     * @return bool
     */
    public function begin();

    /**
     * commit transaction
     * @return bool
     */
    public function commit();

    /**
     * rollback transaction
     * @return bool
     */
    public function rollback();
}
