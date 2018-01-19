<?php

namespace SF\Databases;

use SF\Exceptions\UserException;

abstract class Model implements \ArrayAccess
{

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

    /**
     * @param string $name
     * @param array $params
     * @return ResultSet
     * @throws UserException
     */
    public static function execute(string $name, array $params = []): ResultSet
    {
        return static::executeStatement(static::createStatement($name, $params));
    }

    /**
     * @param string $name
     * @param array $params
     * @return Statement
     * @throws UserException
     */
    public static function createStatement(string $name, array $params = []): Statement
    {
        return static::createStatementBySql(static::getTable()->getSql($name), $params);
    }

    /**
     *
     * @param string $sql
     * @param array $params
     * @return \SF\Databases\ResultSet
     */
    public static function executeSql(string $sql, array $params = []): ResultSet
    {
        return static::executeStatement(static::createStatementBySql($sql, $params));
    }

    /**
     *
     * @param string $sql
     * @param array $params
     * @return \SF\Databases\Statement
     */
    public static function createStatementBySql(string $sql, array $params = []): Statement
    {
        return new Statement($sql, $params);
    }

    /**
     *
     * @param \SF\Databases\Statement $statement
     * @return ResultSet
     */
    public static function executeStatement(Statement $statement): ResultSet
    {
        return (new Executor($statement))->execute();
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
     * @return \SF\Databases\Transaction
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
