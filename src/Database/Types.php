<?php

namespace SF\Database;


class Types
{
    const TINYINT            = 'tinyint';
    const SMALLINT           = 'smallint';
    const MEDIUMINT          = 'mediumint';
    const INT                = 'int';
    const INTEGER            = 'integer';
    const BIGINT             = 'bigint';
    const BIT                = 'bit';
    const REAL               = 'real';
    const DOUBLE             = 'double';
    const FLOAT              = 'float';
    const DECIMAL            = 'decimal';
    const NUMERIC            = 'numeric';
    const CHAR               = 'char';
    const VARCHAR            = 'varchar';
    const DATE               = 'date';
    const TIME               = 'time';
    const YEAR               = 'year';
    const TIMESTAMP          = 'timestamp';
    const DATETIME           = 'datetime';
    const TINYBLOB           = 'tinyblob';
    const BLOB               = 'blob';
    const MEDIUMBLOB         = 'mediumblob';
    const LONGBLOB           = 'longblob';
    const TINYTEXT           = 'tinytext';
    const TEXT               = 'text';
    const MEDIUMTEXT         = 'mediumtext';
    const LONGTEXT           = 'longtext';
    const ENUM               = 'enum';
    const SET                = 'set';
    const BINARY             = 'binary';
    const VARBINARY          = 'varbinary';
    const POINT              = 'point';
    const LINESTRING         = 'linestring';
    const POLYGON            = 'polygon';
    const GEOMETRY           = 'geometry';
    const MULTIPOINT         = 'multipoint';
    const MULTILINESTRING    = 'multilinestring';
    const MULTIPOLYGON       = 'multipolygon';
    const GEOMETRYCOLLECTION = 'geometrycollection';
    const JSON               = 'json';


    const PHP_INTEGER = [
        self::TINYINT,
        self::SMALLINT,
        self::MEDIUMINT,
        self::INT,
        self::INTEGER,
        self::BIGINT
    ];

    const PHP_DOUBLE = [
        self::REAL,
        self::DOUBLE,
        self::FLOAT,
        self::DECIMAL,
        self::NUMERIC,
    ];

    const PHP_STRING = [
        self::CHAR,
        self::VARCHAR,
        self::DATE,
        self::TIME,
        self::YEAR,
        self::TIMESTAMP,
        self::DATETIME,
        self::TINYBLOB,
        self::BLOB,
        self::MEDIUMBLOB,
        self::LONGBLOB,
        self::TINYTEXT,
        self::TEXT,
        self::MEDIUMTEXT,
        self::LONGTEXT,
        self::ENUM,
        self::SET,
        self::BINARY,
        self::VARBINARY,
        self::POINT,
        self::LINESTRING,
        self::POLYGON,
        self::GEOMETRY,
        self::MULTIPOINT,
        self::MULTILINESTRING,
        self::MULTIPOLYGON,
        self::GEOMETRYCOLLECTION,
        self::JSON,
    ];


    public static function getPHPValue($value, Column $column)
    {
        if (in_array($column->type, self::PHP_INTEGER)) {
            if ($column->type === self::BINARY) {
                return PHP_INT_SIZE === 8 && !$column->unsigned ? (int) $value : (string) $value;
            } else if ($column->type === self::INTEGER) {
                return PHP_INT_SIZE === 4 && $column->unsigned ? (string) $value : (int) $value;
            }
            return (int) $value;
        } else if (in_array($column->type, self::PHP_DOUBLE)) {
            return (double) $value;
        } else {
            return (string) $value;
        }
    }
}