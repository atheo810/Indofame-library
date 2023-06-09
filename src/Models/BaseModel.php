<?php 

namespace Indoframe\Core\Models;

use Indoframe\Core\Database\BaseConnection;

abstract class BaseModel {
    protected $db;

    public function __construct(BaseConnection $connection)
    {
        $this->db = $connection->getConnection();
    }
}