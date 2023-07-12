<?php

namespace Atheo\Indoframe\Core\Routing;

class Route
{
    /**
     * Name of the Method
     * @var string $method
     */
    public string $method;

    /**
     * @var string $path
     */
    public string $path;

    /**
     * @var string $controller
     */
    public string $controller;

    /**
     * @var string $action
     */
    public string $action;

    /**
     * @var array<mixed> $routes
     */
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

    public static function get(string $path, string $controller, string $action): object
    {
        return self::addRoute('GET', $path, $controller, $action);
    }
    
    public static function post(string $path, string $controller, string $action): object
    {
        return self::addRoute('POST', $path, $controller, $action);
    }

    public static function addRoute(string $method, string $path, string $controller, string $action): object
    {
        return self::$routes[] = new self($method, $path, $controller, $action);
        
    }

    /**
     * @return array<mixed>
     */
    public static function getRoutes(): array
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
