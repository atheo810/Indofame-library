<?php 

namespace Atheo\Indoframe\Core\Models;

use Atheo\Indoframe\Core\Database\BaseConnection;

abstract class BaseModel {
    protected $db;

    public function __construct(BaseConnection $connection)
    {
        $this->db = $connection->getConnection();
    }
}