<?php

namespace Indoframe\Core\Database;

use Indoframe\Core\Database\BaseConnection;

class MySQLConnection extends BaseConnection
{

    public function connect()
    {
        $host = "localhost";
        $db = "databaseku";
        $user = "root";
        $pass = "";

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->connection = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            // handle connection problem
            // send message with PDOException
            exit("Failed to connect to database: " . $e->getMessage());
        }
    }

    public function table($table)
    {
        return new QueryBuilder($this->connection, $table);
    }

    /**
     * make query From QueryBuilder
     * @param string $query
     */
    public function query($query, $bindings = [])
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($bindings);
        
        return $statement;
    }
    
}
