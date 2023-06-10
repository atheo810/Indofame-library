<?php 

namespace Atheo\Indoframe\Models;

use Atheo\Indoframe\Core\Database\BaseConnection as connection;

abstract class BaseModel {
    protected $db;

    public function __construct(connection $connection)
    {
        $this->db = $connection->getConnection();
    }
}