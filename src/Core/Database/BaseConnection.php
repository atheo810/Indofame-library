<?php

namespace Indoframe\Core\Database;

abstract class BaseConnection
{

    /**
     * Protected Conection
     * 
     */
    protected $connection;

    abstract public function connect();

    public function getConnection(){
        return $this->connection;
    }

    /**
     * Close Connection from database
     * @return null
     */
    public function closeConnection(){
        return $this->connection = null;
    }
}
