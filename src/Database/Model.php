<?php

namespace SF\Database;

use SF\Contracts\Database\Connection;
use SF\Exceptions\UserException;

abstract class Model implements \ArrayAccess
{
    use ConnectionTrait;

    protected $attributes = [];

    abstract public static function tableName(): string;


    public function __get($name)
    {
        $getter = 'get' . $name;
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } elseif (method_exists($this, $getter)) {
            return $this->$getter();
        }
        throw new UserException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (isset($this->attributes[$name])) {
            $this->attributes[$name] = $value;
        } elseif (method_exists($this, $setter)) {
            return $this->$setter($value);
        }
        throw new UserException('Setting unknown property: ' . get_class($this) . '::' . $name);
    }


    public static function getTable(): Table
    {
        return Table::get(static::tableName());
    }

    public static function execute(string $name, array $params = [], Connection $connection = null):ResultSet
    {
        if ($connection === null) {
            $connection = self::getConnection();
        }

        return $connection->prepare(static::getTable()->getSql($name))->execute($connection, $params);
    }

    public static function query(string $sql, Connection $connection = null)
    {
        if ($connection === null) {
            $connection = self::getConnection();
        }

        return $connection->query($sql);
    }


    /**
     * @param ResultSet $resultSet
     * @return array|null|Model[]
     */
    public static function popular(ResultSet $resultSet)
    {
        return new Records(static::class, $resultSet->getResult());
    }

    /**
     *
     * @return \SF\Database\Transaction
     */
    public static function beginTransaction()
    {
        return new Transaction();
    }

    public function offsetExists($attribute)
    {
        return isset($this->attributes[$attribute]);
    }

    public function offsetGet($attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }

    public function offsetSet($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    public function offsetUnset($attribute)
    {
        unset($this->attributes[$attribute]);
    }


}
