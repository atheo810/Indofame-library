<?php

namespace Atheo\Indoframe\Core\Database;

use InvalidArgumentException;

class QueryBuilder
{
    /**
     * @var $connection to save Connection Database
     * @var $table data table from Database
     * @var $query to store data from Query
     */
    private $connection;
    private $table;
    public $query;

    public function __construct(BaseConnection $connection, string $table = "")
    {
        $this->connection = $connection->getConnection();
        $this->table = $table;
        $this->query = '';
    }
    

    /**
     * 
     * @param string $value
     */
    public function quote($value)
    {
        return $this->connection->quote($value);
    }

    /**
     * @param $query return the query from class QueryBuilder
     * @return string
     */
    public function getQuery():string
    {
        return $this->query;
    }

    /**
     * Select Function for SELECT in SQL
     * @param string|array $columns
     * @return object
     */
    public function select(string|array $columns = '*'):object
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }

        $this->query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $this->table;
        return $this;
    }

    /**
     * Using Where SQL to add in the query
     * @param array $conditions
     * @param string $logicalOperator
     * @return object
     */
    public function where(array $conditions, string $logicalOperator = 'AND'):object
    {
        if (!is_array($conditions)) {
            throw new InvalidArgumentException("Invalid conditions. Array expected.");
        }

        $clauses = [];
        foreach ($conditions as $column => $value) {
            $operator = '=';
            if (is_array($value)) {
                if (count($value) != 2) {
                    throw new InvalidArgumentException("Invalid condition format for column '$column'");
                }
                list($operator, $value) = $value;
            }

            $operator = strtoupper(trim($operator));
            if (!in_array($operator, ['=', '!=', '<', '>', '<=', '>=', 'LIKE'])) {
                throw new InvalidArgumentException("Invalid operator '$operator' for column '$column'");
            }

            // prevent SQL injection
            $value = $this->sanitize($value);
            $clauses[] = $column . ' ' . $operator . ' ' . $value;
        }

        $logicalOperator = strtoupper(trim($logicalOperator));
        if (!in_array($logicalOperator, ['AND', 'OR', 'NOT'])) {
            throw new InvalidArgumentException("Invalid logical operator '$logicalOperator'");
        }

        $this->query .= ' WHERE ' . implode(' ' . $logicalOperator . ' ', $clauses);

        return $this;
    }

    /**
     * ORDERBY from SQL
     * @param string $direction
     * @param string|array $columns
     * @return object
     * 
     */
    public function orderBy(string|array $columns, string $direction = 'ASC'):object
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        $this->query .= ' ORDER BY ' . implode(', ', $columns) . ' ' . $direction;
        return $this;
    }

    public function get()
    {
    }

    /**
     * SANITEZE 
     * to prevent SQL injection
     * @param string|int|bool|null $value
     */
    public function sanitize($value)
    {
        if (is_null($value)) {
            return 'NULL';
        } elseif (is_bool($value)) {
            return ($value) ? '1' : '0';
        } elseif (is_numeric($value)) {
            return $value;
        } else {
            return $this->connection->quote($value);
        }
    }

    /**
     * set the limit for Query
     * @param string $limit
     * @param object
     */
    public function limit($limit):object
    {
        $this->query .= ' LIMIT ' . $limit;
        return $this;
    }

    /**
     * Join function for SQL
     * @param string $table
     * @param string $type
     * @param string $on
     * @return object
     */
    public function join(string $table, string $type, string $on):object
    {
        $this->query .= " $type JOIN $table ON $on";
        return $this;
    }

    /**
     * Left Join SQL
     * @param string $table
     * @param string $on
     * @return object
     */
    public function leftJoin(string $table, string $on):object
    {
        $this->query .= " LEFT JOIN $table ON $on";
        return $this;
    }

    /**
     * Right Join SQL
     * @param string $table
     * @param string $on
     * @return object
     */
    public function rightJoin(string $table, string $on):object
    {
        $this->query .= " RIGHT JOIN $table ON $on";
        return $this;
    }

    /**
     * Inner Join SQL
     * @param string $table
     * @param string $on
     * @return object $this
     */
    public function innerJoin(string $table, string $on):object
    {
        $this->query .= " INNER JOIN $table ON $on";
        return $this;
    }

    /**
     * Full Join SQL
     * @param string $table
     * @param string $on
     * @return object
     */
    public function fullJoin(string $table, string $on):object
    {
        $this->query .= " FULL JOIN $table ON $on";
        return $this;
    }

    /**
     * INSERT INTO for SQL Query
     * @param array $data
     * @return object
     */
    public function insert(array $data):object
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map([$this, 'sanitize'], $data));

        $this->query = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        return $this;
    }

    /**
     * Update Query For SQL
     * @param array $data
     * @return object
     */
    public function update(array $data):object
    {
        if (empty($data)) {
            throw new InvalidArgumentException("Empty data for update");
        }

        $this->query = 'UPDATE ' . $this->table . ' SET ';

        $values = [];
        foreach ($data as $column => $value) {
            $values[] = $column . ' = ' . $this->sanitize($value);
        }

        $this->query .= implode(', ', $values);

        return $this;
    }

    public function execute(){
        $statment = $this->connection->query($this->query);

        return $statment;
    }
}
