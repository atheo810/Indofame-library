<?php 

namespace Atheo\Indoframe\Core\Routes;

abstract class BaseRoute{
    // include All route
    protected $routes = [];

    public function getRoutes(): array{
        return $this->routes;
    }
}