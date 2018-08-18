<?php

namespace SF\Database;

use SF\Contracts\Database\Statement as StatementInterface;
use SF\Contracts\Database\Connection;
use SF\Contracts\Support\Jsonable;
use SF\Exceptions\UserException;

abstract class Model implements \ArrayAccess, Jsonable, \JsonSerializable
{

    use ConnectionTrait;

    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    abstract public static function tableName(): string;


    public function __get($name)
    {
        $getter = 'get' . $name;
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } else if (static::getTable()->hasColumn($name)) {
            return null;
        } else if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        throw new UserException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (isset($this->attributes[$name])) {
            $this->attributes[$name] = $value;
        } else if (static::getTable()->hasColumn($name)) {
            $this->attributes[$name] = $value;
        } else if (method_exists($this, $setter)) {
            return $this->$setter($value);
        } else {
            throw new UserException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
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

    public static function getTable(): Table
    {
        return Table::get(static::tableName());
    }

    public static function getSql(string $name)
    {
        return self::getTable()->getSql($name);
    }

    public static function execute(string $name, array $params = [], Connection $connection = null): ResultSet
    {
        if ($connection === null) {
            $connection = self::getConnection();
        }

        return $connection->prepare(self::getSql($name))->execute($params);
    }

    public static function getStatement(Connection $connection, string $sql): StatementInterface
    {
        return $connection->prepare($sql);
    }


    public static function query(string $sql, Connection $connection = null)
    {
        if ($connection === null) {
            $connection = self::getConnection();
        }

        try {
            return $connection->query($sql);
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $connection->close();
        }
    }

    /**
     * @param string $name
     * @param array $params
     * @param Connection|null $connection
     * @return Records
     */
    public static function executeAndPopular(string $name, array $params = [], Connection $connection = null)
    {
        return self::popular(self::execute($name, $params, $connection));
    }

    /**
     * @param ResultSet $resultSet
     * @return Records
     */
    public static function popular(ResultSet $resultSet)
    {
        return new Records(static::class, $resultSet->getResult());
    }

    public static function beginTransaction()
    {
        return new Transaction();
    }

    public function fields()
    {
        return [];
    }

    public function toJson($options = 0)
    {
        $fields = $this->fields();
        if (empty($fields)) {
            return $this->attributes;
        } else {
            return array_intersect_key($this->attributes, array_flip($fields));
        }
    }

    public function jsonSerialize()
    {
        return $this->toJson();
    }


}
