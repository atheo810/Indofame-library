<?php

namespace Atheo\Indoframe\Core\Http;

class Request
{
    /**
     * @var string $method
     */
    private $method;

    /**
     * @var string $uri
     */
    private $uri;

    /**
     * @param string $method
     * @param string $uri
     */
    public function __construct(string $method, string $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
    }

    /**
     * Get Method from this class
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get URI from this Class
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
