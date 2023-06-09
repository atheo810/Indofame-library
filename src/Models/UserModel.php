<?php 

namespace Atheo\Indoframe\Core\Models;

use Atheo\Indoframe\Core\Database\BaseConnection;

class UserModel extends BaseModel{
    public function __construct(BaseConnection $connection)
    {
        parent::__construct($connection);
    }
}