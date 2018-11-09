<?php

namespace SF\Database;

use SF\Context\Database\TransactionContext;
use SF\Contracts\Database\Statement as StatementInterface;
use SF\Contracts\Database\Connection;
use SF\Contracts\Support\Arrayable;
use SF\Contracts\Support\Jsonable;
use SF\Exceptions\UserException;
use SF\Support\Json;

abstract class Model implements \ArrayAccess, Jsonable, \JsonSerializable,Arrayable
{

    use ConnectionTrait;

    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    abstract public static function tableName(): string;

    public static function getTable(): Table
    {
        return Table::get(static::tableName());
    }

    public static function getSql(string $name)
    {
        return self::getTable()->getSql($name);
    }


    /**
     * 开启事务
     * @return Transaction
     */
    public static function beginTransaction()
    {
        return new Transaction();
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

    /**
     * @param string $name
     * @param array $params
     * @param Connection|null $connection
     * @return ResultSet
     */
    public static function execute(string $name, array $params = [], Connection $connection = null): ResultSet
    {
        $transaction = TransactionContext::getTransaction();
        if ($transaction === null) {
            return self::getStatementByName($name, $params, $connection)->execute($params);
        } else {
            return $transaction->execute(self::buildSql($name, $params), $params);
        }
    }

    public static function getStatementByName(string $name, array $params = [], Connection $connection = null)
    {
        if ($connection === null) {
            $connection = self::getConnection();
        }

        return self::getStatement($connection, self::buildSql($name, $params));
    }

    public static function buildSql(string $name, array $params = [])
    {
        $sql = self::getSql($name);

        if ($sql instanceof \Closure) {
            $sql = $sql($params);
        }

        return $sql;
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

    public function fields()
    {
        return [];
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function toJson($options = 0)
    {
        return Json::enCode($this->toArray(), $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        $fields = $this->fields();
        if (empty($fields)) {
            return $this->attributes;
        } else {
            return array_intersect_key($this->attributes, array_flip($fields));
        }
    }

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
}
