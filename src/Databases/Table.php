<?php

namespace SF\Databases;


class Table
{
    private static $tables = [];

    private $tableName;

    private $columns = [];

    private $sqlMap = [];

    public function __construct(string $table, array $columns = [], array $sqlMap = [])
    {
        if (empty($table)) {
            throw new SqlException('Table name pattern can not be NULL or empty.');
        }

        $this->tableName = $table;
        $this->setColumns($columns);
        $this->sqlMap = $sqlMap;
        self::$tables[$table] = $this;
    }


    public function setColumns(array $columns)
    {
        foreach ($columns as $column) {
            $column = new Column($column);
            $this->columns[$column->name] = $column;
        }

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getColumn(string $name): Column
    {
        $column = $this->columns[$name] ?? null;

        if ($column === null) {
            throw new SqlException('The Column:' . $this->tableName . '.' . $name . ' is not exists');
        }

        return $column;
    }

    public function setSqlMap(array $map)
    {
        $this->sqlMap = $map;

        return $this;
    }

    public function getSql(string $name)
    {
        return $this->sqlMap[$name] ?? null;
    }

    public static function add(string $table, array $columns = [], array $sqlMap = [])
    {
        return new static($table, $columns, $sqlMap);
    }

    /**
     * @param string $table
     * @return static
     * @throws SqlException
     */
    public static function get(string $table)
    {
        $table = self::$tables[$table] ?? null;
        if ($table === null) {
            throw new SqlException('The table:' . $table . ' is not exists');
        }

        return $table;
    }


    public static function destroy()
    {
        self::$tables = [];
    }
}