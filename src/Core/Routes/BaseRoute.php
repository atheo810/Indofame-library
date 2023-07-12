<?php 

namespace Atheo\Indoframe\Core\Routes;

abstract class BaseRoute{
    // include All route
    /**
     * @var array<mixed> $routes
     */
    protected $routes = [];

    /**
     * @return array<mixed>
     */
    public function getRoutes(): array{
        return $this->routes;
    }
}