<?php

namespace SF\Contracts\Database;

interface Statement
{

    public function getSql(): string;

    public function getParams(): array;

    public function getRawSql(): string;

    public function execute(Connection $connection, array $params, bool $close = true): ResultSet;
}
