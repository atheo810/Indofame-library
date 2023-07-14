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

    // /**
    //  * Close Connection from database
    //  * @return null
    //  */
    // public function closeConnection(): null{
    //     return $this->connection = null;
    // }

    /**
     * Data Source Name
     * 
     * @var string $DSN
     */
    protected $DSN;

    /**
     * Database Port
     * 
     * @var int|string $port;
     */
    protected $port = '';

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
     * @var array|string $escapeChar
     */
    public $escapeChar = '"';

    /**
     * Connection instance
     * 
     * @var object
     */
    protected $connection;
}
