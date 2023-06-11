<?php

namespace Atheo\Indoframe\Models;

use Atheo\Indoframe\Core\Database\BaseConnection;
use Atheo\Indoframe\Core\Database\QueryBuilder;

abstract class BaseModel
{
    protected $db;
    protected string $table;
    protected $query;

    public function __construct(BaseConnection $connection)
    {
        $this->db = $connection->getConnection();
        $this->query = new QueryBuilder($connection, $this->table);
    }

    public function getConnection()
    {
        return $this->db->getConnection();
    }
}
