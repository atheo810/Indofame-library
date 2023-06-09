<?php

namespace Indoframe\Core\Routes;

class WebRoute extends BaseRoute{
    public function __construct()
    {
        $this->routes = [
            '/home' => 'HomeController@index'
        ];
    }
}   