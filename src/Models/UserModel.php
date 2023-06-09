<?php 

namespace Indoframe\Core\Models;

use Indoframe\Core\Database\BaseConnection;

class UserModel extends BaseModel{
    public function __construct(BaseConnection $connection)
    {
        parent::__construct($connection);
    }
}