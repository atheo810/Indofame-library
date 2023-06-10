<?php 

namespace Atheo\Indoframe\Models;

use Atheo\Indoframe\Core\Database\BaseConnection;

abstract class BaseModel {
    protected $db;

    public function __construct(BaseConnection $connection)
    {
        $this->db = $connection->getConnection();
    }

    public function getConnection(){
        return $this->db->getConnection();
    }
}