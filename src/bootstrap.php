<?php 

namespace Atheo\Indoframe;

use Atheo\Indoframe\Models\BaseModel;
use Atheo\Indoframe\Core\Config;
use Atheo\Indoframe\Core\Config\Paths;
use Atheo\Indoframe\Core\Database;
use Atheo\Indoframe\Core\Database\QueryBuilder;
use Atheo\Indoframe\Core\Http\{BaseController,Request};
use Atheo\Indoframe\Core\Routes\BaseRoute;
use Atheo\Indoframe\Core\Routing\{Route, Router, RouteCollection};
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '../../');
$dotenv->load();