<?php

use Atheo\Indoframe\Core\Database\MySQLi\Connection;
use Atheo\Indoframe\Core\Database\QueryBuilder;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/bootstrap.php';

$baru = new Connection();

var_dump($baru->connect());
print_r($_ENV);

$data = new QueryBuilder();

$data->TABLE("atheo");


print($data
    ->SELECT()
    ->WHERE("data = 1")
    ->OR(["baca", "baru"])
    ->ORDER_BY(["data_absen", "data_baru"])
    ->call());
