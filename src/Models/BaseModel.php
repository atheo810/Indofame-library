<?php

namespace Atheo\Indoframe\Models;

use Atheo\Indoframe\Core\Database\BaseConnection;
use Atheo\Indoframe\Core\Database\QueryBuilder;

abstract class BaseModel
{
    /**
     * @var string $table
     */
    protected string $table;

    /**
     * @var BaseConnection $db
     */
    protected $db;

    /**
     * @var QueryBuilder $query
     */
    protected $query;

    public function __construct(BaseConnection $connection)
    {
        $this->db = $connection->getConnection();
        $this->query = new QueryBuilder($connection, $this->table);
    }

    /**
     * @return BaseConnection
     */
    public function getConnection(): BaseConnection
    {
        return $this->db->getConnection();
    }
}
