<?php

namespace Atheo\Indoframe\Core\Database;

/**
 * Query Builder
 */
class Query implements QueryInterface
{
    /**
     * The query string, as provided by the user.
     *
     * @var string $originalQueryString
     */
    protected $originalQueryString;

    /**
     * The query string if table prefix has been swapped.
     *
     * @var string|null $swappedQueryString
     */
    protected $swappedQueryString;

    /**
     * The final query string after binding, etc.
     *
     * @var string|null $finalQueryString
     */
    protected $finalQueryString;

    /**
     * The binds and their values used for binding.
     *
     * @var array<mixed> $binds
     */
    protected $binds = [];

    /**
     * Bind marker
     *
     * Character used to identify values in a prepared statement.
     *
     * @var string $bindMarker
     */
    protected $bindMarker = '?';

    /**
     * The start time in seconds with microseconds
     * for when this query was executed.
     *
     * @var float|string $startTime
     */
    protected $startTime;


    /**
     * The end time in seconds with microseconds
     * for when this query was executed.
     *
     * @var float $endTime
     */
    protected $endTime;

    /**
     * The error code, if any.
     *
     * @var int $errorCode
     */
    protected $errorCode;

    /**
     * The error message, if any.
     *
     * @var string $errorString
     */
    protected $errorString;

    /**
     * Pointer to database connection.
     * Mainly for escaping features.
     *
     * @var ConnectionInterface $db
     */
    public $db;

    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    /**
     * Sets the raw query string to use for this statement.
     * @param string $sql
     * @param mixed $binds
     * @param bool $setEscape
     *
     * @return $this
     */
    public function setQuery(string $sql, $binds = null, bool $setEscape = true): object
    {
        $this->originalQueryString = $sql;
        unset($this->swappedQueryString);

        if ($binds !== null) {
            if (!is_array($binds)) {
                $binds = [$binds];
            }

            if ($setEscape) {
                array_walk($binds, static function (&$item) {
                    $item = [
                        $item,
                        true,
                    ];
                });
            }
            $this->binds = $binds;
        }

        unset($this->finalQueryString);

        return $this;
    }

    /**
     * Will store the variables to bind into the query later.
     * @param array<mixed> $binds
     * @param bool $setEscape
     * 
     * @return $this
     */
    public function setBinds(array $binds, bool $setEscape = true): object
    {
        if ($setEscape) {
            array_walk($binds, static function (&$item) {
                $item = [$item, true];
            });
        }

        $this->binds = $binds;

        unset($this->finalQueryString);

        return $this;
    }

    /**
     * Returns the final, processed query string after binding, etal
     * has been performed.
     * 
     * @return string|null
     */
    public function getQuery(): string|null
    {
        if (empty($this->finalQueryString)) {
            $this->compileBinds();
        }

        return $this->finalQueryString;
    }

    /**
     * Records the execution time of the statement using microtime(true)
     * for it's start and end values. If no end value is present, will
     * use the current time to determine total duration.
     * @param float $start
     * @param ?float $end
     *
     * @return $this
     */
    public function setDuration(float $start, ?float $end = null): object
    {
        $this->startTime = $start;

        if ($end === null) {
            $end = microtime(true);
        }

        $this->endTime = $end;

        return $this;
    }

    /**
     * Returns the start time in seconds with microseconds.
     *
     * @param bool $returnRaw
     * @param int $decimals
     * 
     * @return string
     */
    public function getStartTime(bool $returnRaw = false, int $decimals = 6): string
    {
        if ($returnRaw) {
            return $this->startTime;
        }

        return number_format($this->startTime, $decimals);
    }

    /**
     * Returns the duration of this query during execution, or null if
     * the query has not been executed yet.
     *
     * @param int $decimals The accuracy of the returned time.
     * 
     * @return string
     */
    public function getDuration(int $decimals = 6): string
    {
        return number_format(($this->endTime - $this->startTime), $decimals);
    }

    /**
     * Stores the error description that happened for this query.
     *
     * @param int $code
     * @param string $error
     * 
     * @return $this
     */
    public function setError(int $code, string $error): object
    {
        $this->errorCode   = $code;
        $this->errorString = $error;

        return $this;
    }

    /**
     * Reports whether this statement created an error not.
     * 
     * @return bool
     */
    public function hasError(): bool
    {
        return !empty($this->errorString);
    }

    /**
     * Returns the error code created while executing this statement.
     * 
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * Returns the error message created while executing this statement.
     * 
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorString;
    }

    /**
     * Determines if the statement is a write-type query or not.
     * 
     * @return bool
     */
    public function isWriteType(): bool
    {
        return $this->db->isWriteType($this->originalQueryString);
    }

    /**
     * Swaps out one table prefix for a new one.
     *
     * @return $this
     */
    public function swapPrefix(string $orig, string $swap): object
    {
        $sql = $this->swappedQueryString ?? $this->originalQueryString;

        $from = '/(\W)' . $orig . '(\S)/';
        $to   = '\\1' . $swap . '\\2';

        $this->swappedQueryString = preg_replace($from, $to, $sql);

        unset($this->finalQueryString);

        return $this;
    }

    /**
     * Returns the original SQL that was passed into the system.
     * 
     * @return string
     */
    public function getOriginalQuery(): string
    {
        return $this->originalQueryString;
    }

    /**
     * Escapes and inserts any binds into the finalQueryString property.
     *
     * @see https://regex101.com/r/EUEhay/5
     */
    protected function compileBinds()
    {
        $sql   = $this->swappedQueryString ?? $this->originalQueryString;
        $binds = $this->binds;

        if (empty($binds)) {
            $this->finalQueryString = $sql;

            return;
        }

        if (is_int(array_key_first($binds))) {
            $bindCount = count($binds);
            $ml        = strlen($this->bindMarker);

            $this->finalQueryString = $this->matchSimpleBinds($sql, $binds, $bindCount, $ml);
        } else {
            // Reverse the binds so that duplicate named binds
            // will be processed prior to the original binds.
            $binds = array_reverse($binds);

            $this->finalQueryString = $this->matchNamedBinds($sql, $binds);
        }
    }

    /**
     * Match bindings
     * @param string $sql
     * @param array<string> $binds
     * 
     * @return string
     */
    protected function matchNamedBinds(string $sql, array $binds): string
    {
        $replacers = [];

        foreach ($binds as $placeholder => $value) {
            // $value[1] contains the boolean whether should be escaped or not
            $escapedValue = $value[1] ? $this->db->escape($value[0]) : $value[0];

            // In order to correctly handle backlashes in saved strings
            // we will need to preg_quote, so remove the wrapping escape characters
            // otherwise it will get escaped.
            if (is_array($value[0])) {
                $escapedValue = '(' . implode(',', $escapedValue) . ')';
            }

            $replacers[":{$placeholder}:"] = $escapedValue;
        }

        return strtr($sql, $replacers);
    }

    /**
     * Match bindings
     * @param string $sql
     * @param array<string> $binds
     * @param int $bindCount
     * @param int $ml
     * 
     * @return string
     */
    protected function matchSimpleBinds(string $sql, array $binds, int $bindCount, int $ml): string
    {
        if ($c = preg_match_all("/'[^']*'/", $sql, $matches)) {
            $c = preg_match_all('/' . preg_quote($this->bindMarker, '/') . '/i', str_replace($matches[0], str_replace($this->bindMarker, str_repeat(' ', $ml), $matches[0]), $sql, $c), $matches, PREG_OFFSET_CAPTURE);

            // Bind values' count must match the count of markers in the query
            if ($bindCount !== $c) {
                return $sql;
            }
        } elseif (($c = preg_match_all('/' . preg_quote($this->bindMarker, '/') . '/i', $sql, $matches, PREG_OFFSET_CAPTURE)) !== $bindCount) {
            return $sql;
        }

        do {
            $c--;
            $escapedValue = $binds[$c][1] ? $this->db->escape($binds[$c][0]) : $binds[$c][0];

            if (is_array($escapedValue)) {
                $escapedValue = '(' . implode(',', $escapedValue) . ')';
            }

            $sql = substr_replace($sql, $escapedValue, $matches[0][$c][1], $ml);
        } while ($c !== 0);

        return $sql;
    }
}
