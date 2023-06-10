<?php

namespace Atheo\Indoframe\Core\Routing;

class Router
{
    private $routes = [];

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @param string $path
     */
    public function get(string $path, $controller, $action)
    {
        $this->routes[] = new Route('GET', $path, $controller, $action);
    }

    private function match($method, $uri)
    {
        foreach ($this->routes as $route) {
            $routeMethod = $route->getMethod();
            $routePath = $route->getPath();

            // Match HTTP method
            if ($routeMethod !== $method) {
                continue;
            }

            // Match URI using regex pattern
            $pattern = '#^' . $routePath . '$#';
            if (preg_match($pattern, $uri)) {
                return $route;
            }
        }

        return null;
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $matchedRoute = $this->match($method, $uri);

        if ($matchedRoute) {
            $controllerName = $matchedRoute->getController();
            $actionName = $matchedRoute->getAction();

            // Check if controller class exists
            $controllerClass = 'app\Controllers\\' . $controllerName;
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();

                // Check if action method exists within the controller class
                if (method_exists($controller, $actionName)) {
                    $response = $controller->$actionName();

                    // Use the response to display or send output
                    echo $response;
                    return;
                }
            }
        }

        // If no matching route or controller/action does not exist, display a 404 Not Found message
        echo "404 Not Found";
    }
}
