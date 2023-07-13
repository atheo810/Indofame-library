<?php

namespace Atheo\Indoframe\Core\Database;

interface ConnectionInterface
{

    /**
     * Initialize the database connection/settings.
     * @return void
     */
    public function initialize(): void;

    /**
     * Connect the database
     * 
     * @param bool $presistent
     * 
     * @return false|object|resource
     */
    public function connect(bool $presistent = false);

    /**
     * Create a persistent database connection.
     *
     * @return false|object|resource
     */
    public function persistentConnect();

    /**
     * Keep or establish the connection if no queries have been sent for
     * a length of time exceeding the server's idle timeout.
     *
     * @return void
     */
    public function reconnect(): void;

    /**
     * Returns the actual connection object. If both a 'read' and 'write'
     * connection has been specified, you can pass either term in to
     * get that connection. If you pass either alias in and only a single
     * connection is present, it must return the sole connection.
     *
     * @param ?string $alias
     * 
     * @return false|object|resource
     */
    public function getConnection(?string $alias = null);

    /**
     * Select a specific database table to use.
     *
     * @param string $databaseName
     * 
     * @return bool
     */
    public function setDatabase(string $databaseName): bool;

    /**
     * Returns the name of the current database being used.
     * 
     * @return string
     */
    public function getDatabase(): string;

    /**
     * Returns the last error encountered by this connection.
     * Must return this format: ['code' => string|int, 'message' => string]
     * intval(code) === 0 means "no error".
     *
     * @return array<string, int|string>
     */
    public function error(): array;

    /**
     * The name of the platform in use (MySQLi, mssql, etc)
     * 
     * @return string
     */
    public function getPlatform(): string;

    /**
     * Returns a string containing the version of the database being used.
     * 
     * @return string
     */
    public function getVersion(): string;

    // /**
    //  * Orchestrates a query against the database. Queries must use
    //  * Database\Statement objects to store the query and build it.
    //  * This method works with the cache.
    //  *
    //  * Should automatically handle different connections for read/write
    //  * queries if needed.
    //  *
    //  * @param string $sql
    //  * @param array|string|null $binds
    //  *
    //  * @return BaseResult|bool|Query
    //  */
    // public function query(string $sql, $binds = null): BaseResult|bool|Query;

    /**
     * Performs a basic query against the database. No binding or caching
     * is performed, nor are transactions handled. Simply takes a raw
     * query string and returns the database-specific result id.
     *
     * @return false|object|resource
     */
    public function simpleQuery(string $sql);

    /**
     * Returns an instance of the query builder for this connection.
     *
     * @param array<mixed>|string $tableName Table name.
     *
     * @return BaseBuilder Builder.
     */
    public function table(array|string $tableName): BaseBuilder;

    /**
     * Returns the last query's statement object.
     *
     * @return Query
     */
    public function getLastQuery(): Query;

    /**
     * "Smart" Escaping
     *
     * Escapes data based on type.
     * Sets boolean and null types.
     *
     * @param array<float|int|string>|bool|float|int|object|string|null $str
     *
     * @return array<float|int|string>|float|int|string
     */
    public function escape(array|bool|float|int|object|string|null $str);

    /**
     * Allows for custom calls to the database engine that are not
     * supported through our database layer.
     *
     * @param array<mixed> ...$params
     * @param string $functionName
     *
     * @return array<mixed>|bool|float|int|object|resource|string|null
     */
    public function callFunction(string $functionName, ...$params);

    /**
     * Determines if the statement is a write-type query or not.
     *
     * @param string $sql
     * 
     * @return bool
     */
    public function isWriteType($sql): bool;
}
