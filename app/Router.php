<?php

namespace App;

class Router
{
    private $routes = [];
    private $currentRoute = null;

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    private function addRoute($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        $requestUri = strtok($requestUri, '?');
        
        // Remove base path if exists (e.g., /laravel/public)
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && strpos($requestUri, $scriptName) === 0) {
            $requestUri = substr($requestUri, strlen($scriptName));
        } elseif (basename($scriptName) === 'public') {
            $parent = dirname($scriptName);
            if ($parent !== '/' && strpos($requestUri, $parent) === 0) {
                $requestUri = substr($requestUri, strlen($parent));
            }
        }
        
        $requestUri = $requestUri ?: '/';

        foreach ($this->routes as $route) {
            $pattern = $this->convertToRegex($route['path']);
            
            if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Remove full match
                
                // Guardar parámetros nombrados en GLOBALS para las vistas
                $namedParams = [];
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $namedParams[$key] = $value;
                    }
                }
                $GLOBALS['route_params'] = $namedParams;
                
                // Extract only numeric keys (positional arguments) for controller methods
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_int($key)) {
                        $params[] = $value;
                    }
                }
                
                $this->currentRoute = $route;
                return $this->executeCallback($route['callback'], $params);
            }
        }

        // 404 Not Found
        http_response_code(404);
        echo $this->render('errors/404');
        exit;
    }

    private function convertToRegex($path)
    {
        // Convert :param to regex capture group
        $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }

    private function executeCallback($callback, $params = [])
    {
        if (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        }

        if (is_string($callback)) {
            list($controller, $method) = explode('@', $callback);
            $controller = "App\\Controllers\\{$controller}";
            
            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $method)) {
                    return call_user_func_array([$controllerInstance, $method], $params);
                }
            }
        }

        throw new \Exception("Invalid route callback");
    }

    public function render($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . "/Views/{$view}.php";
        
        if (file_exists($viewPath)) {
            ob_start();
            include $viewPath;
            return ob_get_clean();
        }
        
        throw new \Exception("View not found: {$view}");
    }
}
