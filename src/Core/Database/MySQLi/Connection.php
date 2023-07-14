<?php

namespace Atheo\Indoframe\Core\Database\MySQLi;

use Atheo\Indoframe\Core\Database\BaseConnection;
use mysqli;
use Throwable;

class Connection extends BaseConnection
{
    /**
     * @var string $hostname
     */
    protected $hostname = getenv("DB_DATABASE");

    /**
     * Make Connection to database
     * 
     * @return mysqli|bool
     */
    public function connect(): mysqli|bool
    {
        return $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }

    public function call(){
        echo $this->hostname;
    }
}
