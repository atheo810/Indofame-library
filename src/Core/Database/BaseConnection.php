<?php

namespace Atheo\Indoframe\Core\Database;

use Closure;
use Throwable;

abstract class BaseConnection
{

    // protected $connection;

    // abstract public function connect();

    // public function getConnection(){
    //     return $this->connection;
    // }

    /**
     * Close Connection from database
     * 
     * @return bool|int
     */
    public function closeConnection(): bool|int
    {
        $this->connection = null;
        return false;
    }

    /**
     * Data Source Name
     * 
     * @var string $DSN
     */
    protected $DSN;

    /**
     * Database Port
     * 
     * @var int|null $port;
     */
    protected $port;

    /**
     * Hostname
     *
     * @var string $hostname
     */
    protected $hostname;

    /**
     * Username
     *
     * @var string $username
     */
    protected $username;

    /**
     * Password
     *
     * @var string $password
     */
    protected $password;

    /**
     * Database name
     *
     * @var string $database
     */
    protected $database;

    /**
     * Table prefix
     *
     * @var string $DBPrefix
     */
    protected $DBPrefix = '';

    /**
     * Character set
     *
     * @var string $charset
     */
    protected $charset = 'utf8';

    /**
     * Identifier escape character
     *
     * @var array<string>|string $escapeChar
     */
    public $escapeChar = '"';

    /**
     * Connection instance
     * 
     * @var object|null
     */
    protected $connection;
}
