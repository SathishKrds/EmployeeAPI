<?php
// src/Router/Router.php
namespace Config;

class Router
{
    protected $routes = [];

    public function get($uri, $controllerMethod)
    {
        $this->routes['GET'][$uri] = $controllerMethod;
    }

    public function post($uri, $controllerMethod)
    {
        $this->routes['POST'][$uri] = $controllerMethod;
    }

    public function dispatch()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Remove query parameters from the URL
        $urlParts = explode('?', $requestUri);
        $url = $urlParts[0];

        if (isset($this->routes[$requestMethod][$url])) {
            $controllerMethod = $this->routes[$requestMethod][$url];
            $params = $this->extractQueryParams($requestUri);
            $this->callControllerMethod($controllerMethod, $params);
        } else {
            // Handle 404 not found
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }

    protected function extractQueryParams($requestUri)
    {
        $params = [];

        // Extract query parameters from the request URI
        if (strpos($requestUri, '?') !== false) {
            $queryString = substr($requestUri, strpos($requestUri, '?') + 1);
            parse_str($queryString, $params);
        }

        return $params;
    }

    protected function callControllerMethod($controllerMethod, $params = [])
    {
        list($controllerName, $methodName) = explode('@', $controllerMethod);

        $controllerNamespace = 'Controllers\\' . str_replace('/', '\\', $controllerName);

        if (class_exists($controllerNamespace)) {
            $controllerInstance = new $controllerNamespace();

            if (method_exists($controllerInstance, $methodName)) {
                $controllerInstance->$methodName($params);
            } else {
                // Handle method not found
                header("HTTP/1.0 404 Not Found");
                echo "404 Method Not Found";
            }
        } else {
            // Handle controller not found
            header("HTTP/1.0 404 Not Found");
            echo "404 Controller Not Found";
        }
    }
}
?>
