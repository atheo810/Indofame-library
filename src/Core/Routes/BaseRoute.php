<?php 

namespace Indoframe\Core\Routes;

abstract class BaseRoute{
    // include All route
    protected $routes = [];

    public function getRoutes(){
        return $this->routes;
    }
}