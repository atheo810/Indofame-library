<?php

namespace Atheo\Indoframe\Core\Database;

class QueryBuilder extends Query
{
    /**
     * table of database
     * 
     * @var string $table
     */
    protected $table;

    /**
     * limit 
     * 
     * @var string $limit
     */
    protected $limit = '';

    /**
     * Where Query
     * 
     * @var array<string|int> $wheres
     */
    protected $wheres = [];

    /**
     * Joins 
     * 
     * @var array<string>
     */
    protected $joins = [];

    /**
     * Joins function
     * 
     * @param string $query
     * 
     * @return self
     */
    public function JOIN(string $query): self
    {
        $this->query .= " JOIN " . $query;
        return $this;
    }

    /**
     * AND function
     * 
     * @param string|array<string> $queries
     * 
     * @return self
     */
    public function AND(string|array $queries): self
    {
        if (is_array($queries)) {
            $this->query .= " AND " . implode(" AND ", $queries);
            return $this;
        } else {
            $this->query .= " AND " . $queries;
            return $this;
        }
    }

    /**
     * OR function
     * 
     * @param string|array<string> $queries
     * 
     * @return self
     */
    public function OR(string|array $queries): self
    {
        if (is_array($queries)) {
            $this->query .= " OR " . implode(" OR ", $queries);
            return $this;
        } else {
            $this->query .= " OR " . $queries;
            return $this;
        }
    }

    /**
     * SELECT function
     * 
     * @param string $query
     * 
     * @return self
     */
    public function SELECT(string $query = "*"): self
    {
        $this->query = "SELECT " . $query . " FROM " . $this->table;
        return $this;
    }

    /**
     * Declare table function
     * 
     * @param string $table
     * 
     * @return void
     */
    public function TABLE(string $table): void
    {
        $this->table = $table;
    }

    /**
     * Where function
     * 
     * @param string $query
     *
     * @return self 
     */
    public function WHERE(string $query): self
    {
        $this->query .= " WHERE " . $query;
        return $this;
    }

    public function call(): string
    {
        return $this->query;
    }

    /**
     * ORDER_BY function
     * 
     * @param string|array<string> $queries
     * 
     * @return self
     */
    public function ORDER_BY(string|array $queries): self
    {
        if (is_array($queries)) {
            $this->query .= " ORDER BY " . implode(", ", $queries);
            return $this;
        } else {
            $this->query .= " ORDER BY " . $queries;
            return $this;
        }
    }

    /**
     * NOT function 
     * 
     * @param string $query
     * 
     * @return self
     */
    public function NOT(string $query): self
    {
        $this->query .= " NOT " . $query;
        return $this;
    }

    /**
     * IS_NULL function 
     * 
     * @return self
     */
    public function IS_NULL(): self
    {
        $this->query .= " IS NULL";
        return $this;
    }

    /**
     * IS_NOT_NULL function 
     * 
     * @return self
     */
    public function IS_NOT_NULL(): self
    {
        $this->query .= " IS NOT NULL";
        return $this;
    }
}
