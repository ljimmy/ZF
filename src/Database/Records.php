<?php

namespace SF\Database;


use SF\Contracts\Support\Arrayable;

class Records  implements \IteratorAggregate, \Countable,Arrayable
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

    public function get()
    {
        if (empty($this->models)) {
            return null;
        } else {
            return current($this->models);
        }
    }

    /**
     * 附加关联数据
     * @param string $field 当前表的字段名
     * @param string $foreign 关联表的字段名
     * @param Relation $relation
     * @param string|null $alias 别名
     * @param bool $multiple 是否多个
     * @return $this
     */
    public function relation(string $field, string $foreign, Relation $relation, string $alias = null, bool $multiple = false)
    {
        $values = [];
        $modelList = [];

        foreach ($this->models as $model) {
            $val = $model->offsetGet($field);

            if ($val === null) {
                continue;
            }

            if (isset($modelList[$val])) {
                $modelList[$val][] = $model;
            } else {
                $values[] = $val;
                $modelList[$val] = [$model];
            }
        }
        if (empty($values)) {
            return $this;
        }

        foreach ($relation->getStatement($values)->execute($values)->getResult() as $item) {
            if (!isset($modelList[$item[$foreign]])) {
                continue;
            }
            foreach ($modelList[$item[$foreign]] as $model) {
                if ($model->offsetGet($field) == $item[$foreign]) {
                    if (!$alias) {
                        $alias = $field;
                    }

                    if ($multiple) {
                        $v = $model->offsetGet($alias);
                        if ($v === null) {
                            $v = [$item];
                        } else {
                            $v[] = $item;
                        }
                        $model->offsetSet($alias, $v);

                    } else {
                        $model->offsetSet($alias, $item);
                    }
                }
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return array_map(function ($model) {
            return $model->toArray();
        }, $this->models);
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