<?php

namespace Atheo\Indoframe\Core\Database;

use BadMethodCallException;

interface PreparedQueryInterface
{
    /**
     * Explicity close the statement
     * 
     * @throws BadMethodCallException
     */
    public function close(): string;

    /**
     * Prepares the query against the database, and saves the connection
     * info necessary to execute the query later.
     * 
     * @param string $sql
     * @param array<mixed> $option
     * 
     * @return $this
     */
    public function prepare(string $sql, array $option = []): self;
}
