<?php

namespace Atheo\Indoframe\Core\Database;

class RawSql
{
    /**
     * Raw SQL string
     * 
     *  @var string $string 
     */
    private string $string;

    public function __construct(string $sqlString)
    {
        $this->string = $sqlString;
    }

    /**
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->string;
    }

    /**
     * Create new instance with new SQL String
     * 
     * @param string $newSqlString
     * 
     * @return object $new
     */
    public function with(string $newSqlString): object
    {
        $new = clone $this;
        $new->string = $newSqlString;

        return $new;
    }

    /**
     * Returns unique id for binding key
     * 
     * @return string 
     */
    public function getBindingKey(): string
    {
        return 'RawSql' . spl_object_id($this);
    }
}
