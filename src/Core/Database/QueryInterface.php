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
     * @return string
     */
    public function getQuery(): string;

    /**
     * Records the execution time of the statement using microtime(true)
     * for it's start and end values. If no end value is present, will
     * use the current time to determine total duration.
     * 
     * @param float $start
     * @param ?float $end
     *
     * @return object
     */
    public function setDuration(float $start, ?float $end = null): object;

    /**
     * Returns the duration of this query during execution, or null if
     * the query has not been executed yet.
     *
     * @param int $decimals The accuracy of the returned time.
     * 
     * @return string
     */
    public function getDuration(int $decimals = 6): string;

    /**
     * Stores the error description that happened for this query.
     * 
     * @param int $code 
     * @param string $error
     * 
     */
    public function setError(int $code, string $error): object;

    /**
     * Reports whether this statement created an error not.
     * 
     * @return bool
     */
    public function hasError(): bool;

    /**
     * Returns the error code created while executing this statement.
     * 
     * @return int
     */
    public function getErrorCode(): int;

    /**
     * Returns the error message created while executing this statement.
     */
    public function getErrorMessage(): string;

    /**
     * Determines if the statement is a write-type query or not.
     */
    public function isWriteType(): bool;

    /**
     * Swaps out one table prefix for a new one.
     *
     * @return object
     */
    public function swapPrefix(string $orig, string $swap): object;
}
