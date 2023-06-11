<?php

namespace Atheo\Indoframe\Core\Routing;

class Route
{
    public $method;
    public $path;
    public $controller;
    public $action;
    public static $routes = [];

    /**
     * @param string $method
     * @param string $path
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $method, string $path, string $controller, string $action)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    public static function get(string $path, string $controller, string $action)
    {
        return self::addRoute('GET', $path, $controller, $action);
    }
    
    public static function post(string $path, string $controller, string $action)
    {
        return self::addRoute('POST', $path, $controller, $action);
    }

    public static function addRoute(string $method, string $path, string $controller, string $action)
    {
        return self::$routes[] = new self($method, $path, $controller, $action);
        
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

}
