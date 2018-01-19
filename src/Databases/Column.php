<?php

namespace SF\Databases;

class Column
{

    /**
     * 字段
     * @var string
     */
    public $name;

    /**
     * 类型
     * @var string
     */
    public $type;

    /**
     * 默认值
     * @var mixed
     */
    public $default;

    /**
     * 主键
     * @var bool
     */
    public $primaryKey = false;

    /**
     * 可为空
     * @var bool
     */
    public $allowNull = true;


    /**
     * 自动增加
     * @var bool
     */
    public $autoincrement = false;

    /**
     * 无符号
     * @var bool
     */
    public $unsigned = false;

    public function __construct(array $column = [])
    {
        foreach ($column as $key => $value) {
            $this->$key = $value;
        }

        if ($this->name === null) {
            throw new SqlException('Column name pattern can not be NULL or empty.');
        }
    }
}