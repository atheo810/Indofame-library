<?php

namespace Atheo\Indoframe\Core\Routing;

class Route
{
    private $method;
    private $path;
    private $controller;
    private $action;

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

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }
}
