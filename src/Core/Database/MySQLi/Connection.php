<?php

namespace Atheo\Indoframe\Core\Database\MySQLi;

use Atheo\Indoframe\Core\Database\BaseConnection;
use mysqli;
use Dotenv\Dotenv;
use Exception;
use Throwable;

class Connection extends BaseConnection
{

    /**
     * Make Connection to database
     * 
     * @return mysqli|bool
     */
    public function connect(): mysqli|bool
    {
        try {
            $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);
            return $this->connection;
        } catch (Exception $err) {
            echo $err->getMessage();
            return false;
        }
    }

    public function __construct()
    {
        $this->hostname = $_ENV["DB_HOST"];
        $this->username = $_ENV["DB_USERNAME"];
        $this->password = $_ENV["DB_PASSWORD"];
        $this->database = $_ENV["DB_DATABASE"];
        $this->port = $_ENV["DB_PORT"];
    }
}
