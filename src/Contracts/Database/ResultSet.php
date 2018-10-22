<?php

namespace SF\Contracts\Database;

interface ResultSet extends \IteratorAggregate, \Countable
{

    public function first();

    public function get(string $column): array;

    public function getResult(): array;

    public function field(string $name = null);

    public function getLastInsertId(): int;

    public function getAffectedRows(): int;
}
