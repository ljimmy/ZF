<?php

namespace SF\Database;

class Records  implements \IteratorAggregate, \Countable
{

    /**
     * @var Model[]
     */
    private $models = [];

    public function __construct($class, array $rows = [])
    {
        $this->models = $this->createModels($class, $rows);
    }

    protected function createModels(string $class, array $rows = [])
    {
        if (empty($rows)) {
            return [];
        }

        $table = $class::getTable();

        $models = [];
        foreach ($rows as $row) {
            $model = new $class();
            foreach ($row as $field => $value) {
                $model[$field] = Types::getPHPValue($value, $table->getColumn($field));
            }
            $models[] = $model;
        }
        return $models;

    }

    public function getIterator()
    {
        return new \ArrayIterator($this->models);
    }

    public function count()
    {
        return count($this->models);
    }


}