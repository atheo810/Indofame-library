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


    /**
     * Return Method
     * @return string 
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Return Path
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get Controller Name
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * Get function inside the Controller
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
