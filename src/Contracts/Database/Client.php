<?php

namespace SF\Contracts\Database;

interface Client
{

    public function getConnection();
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
