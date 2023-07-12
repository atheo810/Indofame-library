<?php

namespace Atheo\Indoframe\Core\Database;

use Atheo\Indoframe\Core\Database\BaseConnection;
use Closure;
use Exception;
use InvalidArgumentException;

class BaseBuilder
{
    /**
     * Reset DELETE data flag
     * 
     * @var bool $resetDeleteData
     */
    protected $resetDeleteData = false;

    /**
     * Query Builder SELECT data
     *
     * @var array<mixed> $QueryBuilderSelect
     */
    protected $QueryBuilderSelect = [];

    /**
     * Query Builder DISTINCT flag
     *
     * @var bool $QueryBuilderDistinct
     */
    protected $QueryBuilderDistinct = false;

    /**
     * Query Builder FROM data
     *
     * @var array<mixed> $QueryBuilderFrom
     */
    protected $QueryBuilderFrom = [];

    /**
     * Query Builder JOIN data
     *
     * @var array<mixed> $QueryBuilderJoin
     */
    protected $QueryBuilderJoin = [];

    /**
     * Query Builder WHERE data
     *
     * @var array<mixed> $QueryBuilderWhere
     */
    protected $QueryBuilderWhere = [];

    /**
     * Query Builder GROUP BY data
     *
     * @var array<mixed> $QueryBuilderGroupBy
     */
    public $QueryBuilderGroupBy = [];

    /**
     * Query Builder HAVING data
     *
     * @var array<mixed> $QueryBuilderHaving
     */
    protected $QueryBuilderHaving = [];

    /**
     * Query Builder keys
     * list of column names.
     *
     * @var string[] $QueryBuilderKeys
     */
    protected $QueryBuilderKeys = [];

    /**
     * Query Builder LIMIT data
     *
     * @var bool|int $QueryBuilderLimit
     */
    protected $QueryBuilderLimit = false;

    /**
     * Query Builder OFFSET data
     *
     * @var bool|int $QueryBuilderOffset
     */
    protected $QueryBuilderOffset = false;

    /**
     * Query Builder ORDER BY data
     *
     * @var array<mixed> $QueryBuilderOrderBy
     */
    public $QueryBuilderOrderBy = [];

    /**
     * Query Builder UNION data
     *
     * @var array<string> $QueryBuilderUnion
     */
    protected array $QueryBuilderUnion = [];

    /**
     * Query Builder NO ESCAPE data
     *
     * @var array<mixed> $QuilderBuilderNoEscape
     */
    public $QuilderBuilderNoEscape = [];

    /**
     * Query Builder data sets
     *
     * @var array[]|string[]
     * @phpstan-var array<string, string>|list<list<string|int>>
     */
    protected $QueryBuilderSet = [];

    /**
     * Query Builder WHERE group started flag
     *
     * @var bool $QueryBuilderWhereGroupStarted
     */
    protected $QueryBuilderWhereGroupStarted = false;

    /**
     * Query Builder WHERE group count
     *
     * @var int $QueryBuilderWhereGroupCount
     */
    protected $QueryBuilderWhereGroupCount = 0;

    /**
     * Ignore data that cause certain
     * exceptions, for example in case of
     * duplicate keys.
     *
     * @var bool $QueryBuilderIgnore
     */
    protected $QueryBuilderIgnore = false;

    /**
     * Query Builder Options data

     * @var array<mixed> $QueryBuilderOptions
     */
    protected $QueryBuilderOptions;

    /**
     * A Reference to the database Connection
     * 
     * @var BaseConnection $db
     */
    protected $db;

    /**
     * Name Primary Table for this instance
     * @var string $tableName
     */
    protected $tableName;

    /**
     * ORDER BY random keyword
     * 
     * @var array<mixed> $randomKeyword
     */
    protected $randomKeyword = [
        'RAND()',
        'RAND(%d)',
    ];

    /**
     * COUNT string 
     * 
     * @var string $countString
     */
    protected $countString = 'SELECT COUNT(*) AS ';

    /**
     * Collects the named parameters and
     * their values for later binding
     * in the Query object.
     * 
     * @var array<mixed> $binds
     */
    protected $binds = [];

    /**
     * Collects the key count for named parameters
     * in the Query object.
     *
     * @var array<mixed> $bindsKeyCount
     */
    protected $bindsKeyCount = [];

    /**
     * Some databases, like SQLite, do not by default
     * allow limiting of delete clauses.
     *
     * @var bool $canLimitDeletes
     */
    protected $canLimitDeletes = true;

    /**
     * Some databases do not by default
     * allow limit update queries with WHERE.
     *
     * @var bool $canLimitWhereUpdates
     */
    protected $canLimitWhereUpdates = true;

    /**
     * Specifies which sql statements
     * support the ignore option.
     *
     * @var array<mixed> $supportedIgnoreStatements
     */
    protected $supportedIgnoreStatements = [];

    /**
     * Builder testing mode status.
     *
     * @var bool $testMode
     */
    protected $testMode = false;

    /**
     * Tables relation types
     *
     * @var array<string> $joinTypes
     */
    protected $joinTypes = [
        'LEFT',
        'RIGHT',
        'OUTER',
        'INNER',
        'LEFT OUTER',
        'RIGHT OUTER',
    ];

    /**
     * Strings that determine if a string represents a literal value or a field name
     *
     * @var string[] $isLiteralStr
     */
    protected $isLiteralStr = [];

    /**
     * RegExp used to get operators
     *
     * @var string[] $pregOperators
     */
    protected $pregOperators = [];

    /**
     * Returns the current database connection
     *
     * @return BaseConnection|ConnectionInterface
     */
    public function db(): BaseConnection|ConnectionInterface
    {
        return $this->db;
    }

    /**
     * @param string $tableName
     * @param ConnectionInterface $db
     * @param ?array<mixed> $options
     * 
     * @throws Exception
     */
    public function __construct(string $tableName, ConnectionInterface $db, ?array $options = null)
    {
        if (empty($tableName)) {
            throw new Exception("A table must be specified when creating a new Query Builder.");
        }

        /**
         * @var BaseConnection $db
         */
        $this->db = $db;

        // If it contains `,`, it has multiple tables
        if (is_string($tableName) && strpos($tableName, ',') === false) {
            $this->tableName = $tableName;  // @TODO remove alias if exists
        } else {
            $this->tableName = '';
        }

        if (!empty($options)) {
            foreach ($options as $option => $value) {
                if (property_exists($this, $option)) {
                    $this->{$option} = $value;
                }
            }
        }
    }

    /**
     * Sets a test mode status.
     * @param bool $mode
     *
     * @return $this
     */
    public function testMode(bool $mode = true): object
    {
        $this->testMode = $mode;

        return $this;
    }

    /**
     * Gets the name of the primary table.
     * 
     * @return string
     */
    public function getTable(): string
    {
        return $this->tableName;
    }

    /**
     * Returns an array of bind values and their
     * named parameters for binding in the Query object later.
     * 
     * @return array<mixed>
     * 
     */
    public function getBinds(): array
    {
        return $this->binds;
    }
}
