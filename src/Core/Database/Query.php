<?php

namespace Atheo\Indoframe\Core\Database;

class Query implements QueryInterface
{

    /**
     * The final query string after binding, etc.
     *
     * @var string|null $finalQueryString
     */
    protected $finalQueryString;

    /**
     * @param string $sql
     * @param bool $setEscape
     * 
     * @return self
     */
    public function setQuery(string $sql, $binds = null, bool $setEscape = true): self
    {
        return $this;
    }

    /**
     * @return ?string
     */
    public function getQuery(): ?string
    {
        return $this->finalQueryString;
    }

    /**
     * Protected
     * 
     * @var string $query
     */
    protected string $query;



}
