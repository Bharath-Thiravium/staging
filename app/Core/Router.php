<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $pattern, callable|array $handler): void
    {
        $this->routes['GET'][$pattern] = $handler;
    }

    public function post(string $pattern, callable|array $handler): void
    {
        $this->routes['POST'][$pattern] = $handler;
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $uri    = $request->uri();

        foreach ($this->routes[$method] ?? [] as $pattern => $handler) {
            $regex  = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
            if (!preg_match($regex, $uri, $matches)) continue;

            // Named capture groups become params
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            $this->call($handler, $params);
            return;
        }

        $this->notFound();
    }

    private function call(callable|array $handler, array $params): void
    {
        if (is_callable($handler)) {
            call_user_func($handler, $params);
            return;
        }

        [$class, $method] = $handler;
        (new $class())->$method($params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        $view = ROOT_PATH . '/templates/404.php';
        if (file_exists($view)) require $view;
        else echo '<h1>404 — Page Not Found</h1>';
    }
}
