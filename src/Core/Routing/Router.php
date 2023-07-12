<?php

namespace Atheo\Indoframe\Core\Routing;

class Router
{
    /**
     * @var array<Route> $routes
     */
    protected static $routes = [];

    /**
     * @param string $path
     * @param string $controller
     * @param string $action
     * @return void
     */
    public static function get(string $path, string $controller, string $action): void
    {
        self::$routes[] = Route::get($path, $controller, $action);
    }

    /**
     * @param string $path
     * @param string $controller
     * @param string $action
     */
    public static function post(string $path, string $controller, string $action): void
    {
        self::$routes[] = Route::post($path, $controller, $action);
    }

    /**
     * @param string $method
     * @param string $uri
     */
    private function match(string $method, string $uri): object
    {
        foreach (self::$routes as $route) {
            $routeMethod = $route->method;
            $routePath = $route->path;

            if ($routeMethod !== $method) {
                continue;
            }

            $pattern = '#\w' . $routePath . '/?([[:alnum:]])?#';

            if (preg_match($pattern, $uri)) {
                return $route;
            }
        }

        // return null;
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $matchedRoute = $this->match($method, $uri);

        if ($matchedRoute) {
            $controllerName = $matchedRoute->getController();
            $actionName = $matchedRoute->getAction();

            $controllerClass = 'app\Controllers\\' . $controllerName;
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();

                if (method_exists($controller, $actionName)) {
                    $response = $controller->$actionName();
                    echo $response;
                    return;
                }
            }
        }

        include VIEWPATH . "_404.php";
    }
}
