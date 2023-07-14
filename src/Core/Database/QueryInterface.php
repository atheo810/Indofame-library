<?php

namespace Atheo\Indoframe\Core\Database;

interface QueryInterface
{
    /**
     * Sets the raw query string to use for this statement.
     *
     * @param string $sql
     * @param mixed $binds
     * @param bool $setEscape
     *
     * @return object
     */
    public function setQuery(string $sql, $binds = null, bool $setEscape = true): object;

    /**
     * Returns the final, processed query string after binding, etal
     * has been performed.
     *
     * @return string|null
     */
    public function getQuery(): string|null;

}
