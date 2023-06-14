<?php

namespace Atheo\Indoframe\Models;

use Atheo\Indoframe\Core\Database\QueryBuilder;

class BaseModel
{
    protected static $connection;
    protected static $table;
    protected static $queryBuilder;

    public static function init($connection, $table)
    {
        self::$connection = $connection;
        self::$table = $table;
        self::$queryBuilder = new QueryBuilder(self::$connection, self::$table);
    }

    public static function where($column, $operator, $value = null): string
    {
        self::$queryBuilder->where([$column => $value], $operator);
        return self::class;
    }

    public static function select(): string
    {
        self::$queryBuilder->select();
        return self::class;
    }

    public static function orderBy($columns, $direction = 'ASC'): string
    {
        self::$queryBuilder->orderBy($columns, $direction);
        return self::class;
    }

    public static function limit($limit): string
    {
        self::$queryBuilder->limit($limit);
        return self::class;
    }

    public static function join($table, $type, $on): string
    {
        switch ($type) {
            case 'left':
                self::$queryBuilder->leftJoin($table, $on);
                break;
            case 'right':
                self::$queryBuilder->rightJoin($table, $on);
                break;
            case 'inner':
                self::$queryBuilder->innerJoin($table, $on);
                break;
            case 'full':
                self::$queryBuilder->fullJoin($table, $on);
                break;
            default:
                break;
        }
        return self::class;
    }

    public static function insert($data): string
    {
        self::$queryBuilder->insert($data);
        return self::class;
    }

    public static function update($data): string
    {
        self::$queryBuilder->update($data);
        return self::class;
    }

    public static function execute()
    {
        return self::$queryBuilder->execute();
    }
}
