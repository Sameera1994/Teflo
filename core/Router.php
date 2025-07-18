<?php
namespace Teflo\Core;

class Router {
    protected array $routes = [];

    public function get(string $uri, string $controllerAction) {
        $this->addRoute('GET', $uri, $controllerAction);
    }

    public function post(string $uri, string $controllerAction) {
        $this->addRoute('POST', $uri, $controllerAction);
    }

    protected function addRoute(string $method, string $uri, string $controllerAction) {
        $this->routes[$method][$uri] = $controllerAction;
    }

    public function dispatch(string $uri, string $method) {
        $uri = parse_url($uri, PHP_URL_PATH);
        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controller, $method] = explode('@', $action);
        $controllerClass = "App\\Controllers\\$controller";

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller $controllerClass not found");
        }

        $controllerInstance = new $controllerClass();
        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method $method not found in $controllerClass");
        }

        echo $controllerInstance->$method();
    }
}

?>