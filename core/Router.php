<?php

namespace core;
class Router
{
    private array $routes = [
        "GET" => [],
        "POST" => [],
        "DELETE" => [],
        "PUT" => [],
        "PATCH" => []
    ];
    public function get(string $uri, string $action): void
    {
        $this->register($uri, $action, "GET");
    }
    public function post(string $uri, string $action): void
    {
        $this->register($uri, $action, "POST");
    }
    public function delete(string $uri, string $action): void
    {
        $this->register($uri, $action, "DELETE");
    }
    public function put(string $uri, string $action): void
    {
        $this->register($uri, $action, "PUT");
    }

    public function patch(string $uri, string $action): void
    {
        $this->register($uri, $action, "PATCH");
    }
    public function register(string $uri, string $action, string $method): void
    {
        [$controller, $function] = explode("_", $action);
        $pattern = $this->convertUriToPattern($uri);
        $this->routes[$method][$pattern] = [
            'controller' => $controller,
            'method' => $function,
        ];
    }
    public function addRoutes(Router $router) : void
    {
        $this->routes = array_merge_recursive($this->routes, $router->getRoutes());
    }
    private function convertUriToPattern(string $uri): string
    {
        $pattern = preg_replace('/\{([^\/]+)\}\?/', '([^\/]*)', $uri);
        return preg_replace('/\{([^\/]+)\}/', '([^\/]+)', $pattern);
    }
    public function run(): void
    {
        $uri = '/' . (filter_input(INPUT_GET, 'route') ?? '');
        $method = $_SERVER['REQUEST_METHOD'];
        $route = $this->matchRoute($uri, $method);
        if (!$route || !$this->isRouteExist($route)) {
            $this->error(404);
        }
        $this->executeRoute($route);
    }
    private function getControllerAndMethod(array $route): array
    {
        $controllerName = "\\controllers\\" . $route["route"]['controller'];
        $methodName = $route["route"]['method'];
        return [$controllerName, $methodName];
    }
    private function isRouteExist(array $route): bool
    {
        [$controllerName, $methodName] = $this->getControllerAndMethod($route);
        return class_exists($controllerName) && method_exists($controllerName, $methodName);
    }
    private function executeRoute(array $route): void
    {
        [$controllerName, $methodName] = $this->getControllerAndMethod($route);
        $params = $route['params'];
        $controller = new $controllerName();
        try{
            $params = array_filter($params);
            if (!empty($params)) {
                call_user_func_array([$controller, $methodName], $params);
            } else {
                call_user_func([$controller, $methodName]);
            }
        }
        catch (\Throwable $e) {
            $this->error(500);
        }
    }
    private function matchRoute(string $uri, string $method): ?array
    {
        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                return ["route"=>$route, "params" => array_slice($matches, 1)];
            }
        }
        return null;
    }

    //Перенести в окремий клас
    private function error(int $code = 404): void
    {
        http_response_code($code);
        die();
    }
    public function getRoutes() : array
    {
        return $this->routes;
    }
}