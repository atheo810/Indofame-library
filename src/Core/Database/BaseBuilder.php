<?php

namespace Atheo\Indoframe\Core\Database;

class BaseBuilder
{
    /**
     * Reset DELETE data flag
     * 
     * @var bool
     */
    protected $resetDeleteData = false;

    /**
     * Query Builder SELECT data
     *
     * @var array
     */
    protected $QueryBuilderBSelect = [];

    /**
     * Query Builder DISTINCT flag
     *
     * @var bool
     */
    protected $QueryBuilderDistinct = false;

    /**
     * Query Builder FROM data
     *
     * @var array
     */
    protected $QueryBuilderFrom = [];

    /**
     * Query Builder JOIN data
     *
     * @var array
     */
    protected $QueryBuilderJoin = [];

    /**
     * Query Builder WHERE data
     *
     * @var array
     */
    protected $QueryBuilderWhere = [];

    /**
     * Query Builder GROUP BY data
     *
     * @var array
     */
    public $QueryBuilderGroupBy = [];

    /**
     * Query Builder HAVING data
     *
     * @var array
     */
    protected $QueryBuilderHaving = [];

    /**
     * Query Builder keys
     * list of column names.
     *
     * @var string[]
     */
    protected $QueryBuilderKeys = [];

    /**
     * Query Builder LIMIT data
     *
     * @var bool|int
     */
    protected $QueryBuilderLimit = false;

    /**
     * Query Builder OFFSET data
     *
     * @var bool|int
     */
    protected $QueryBuilderOffset = false;

    /**
     * Query Builder ORDER BY data
     *
     * @var array|string|null
     */
    public $QueryBuilderOrderBy = [];

    /**
     * Query Builder UNION data
     *
     * @var array<string>
     */
    protected array $QueryBuilderUnion = [];

    /**
     * Query Builder NO ESCAPE data
     *
     * @var array
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
     * @var bool
     */
    protected $QueryBuilderWhereGroupStarted = false;

    /**
     * Query Builder WHERE group count
     *
     * @var int
     */
    protected $QueryBuilderWhereGroupCount = 0;

    /**
     * Ignore data that cause certain
     * exceptions, for example in case of
     * duplicate keys.
     *
     * @var bool
     */
    protected $QueryBuilderIgnore = false;

    /**
     * Query Builder Options data
     * Holds additional options and data used to render SQL
     * and is reset by resetWrite()
     *
     * @phpstan-var array{
     *   updateFieldsAdditional?: array,
     *   tableIdentity?: string,
     *   updateFields?: array,
     *   constraints?: array,
     *   setQueryAsData?: string,
     *   sql?: string,
     *   alias?: string
     * }
     * @var array
     */
    protected $QueryBuilderOptions;
}
