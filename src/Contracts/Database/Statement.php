<?php

namespace SF\Contracts\Database;

interface Statement
{

    public function getRawSql(): string;

    public function execute(array $params = []): ResultSet;
}
