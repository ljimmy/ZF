<?php

namespace SF\Contracts\Database;

interface Connection
{

    const TRANSACTION_NONE = 0;

    const TRANSACTION_READ_COMMITTED = 2;

    const TRANSACTION_READ_UNCOMMITTED = 1;

    const TRANSACTION_REPEATABLE_READ = 4;

    const TRANSACTION_SERIALIZABLE = 8;

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
     * @return bool
     */
    public function rollback():bool ;

    /**
     * @param string $sql
     * @return Statement
     */
    public function prepare(string $sql): Statement;

    /**
     * @param Statement $statement
     * @return ResultSet
     */
    public function execute(Statement $statement): ResultSet;

    /**
     * @param string $sql
     * @return mixed
     */
    public function query(string $sql);

    /**
     * @return bool
     */
    public function close(): void;

    /**
     * @return bool
     */
    public function isClosed(): bool;
}
