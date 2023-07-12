<?php

namespace Atheo\Indoframe\Core\Database;

class RawSql
{
    /**
     *  @var string Raw SQL string
     */
    private string $string;

    public function __construct(string $sqlString)
    {
        $this->string = $sqlString;
    }

    public function __toString(): string
    {
        return $this->string;
    }

    /**
     * Create new instance with new SQL String
     */
    public function with(string $newSqlString)
    {
        $new = clone $this;
        $new->string = $newSqlString;

        return $new;
    }

    /**
     * Returns unique id for binding key
     */
    public function getBindingKey(): string
    {
        return 'RawSql' . spl_object_id($this);
    }
}
