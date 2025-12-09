<?php

declare(strict_types=1);

namespace BrickPHP\Routing;

/**
 * Router Class
 * 
 * RESTful routing system with parameter support.
 */
class Router
{
    private array $routes = [];
    private array $namedRoutes = [];
    
    /**
     * Register GET route
     */
    public function get(string $path, array|string $handler, ?string $name = null): self
    {
        return $this->addRoute('GET', $path, $handler, $name);
    }
    
    /**
     * Register POST route
     */
    public function post(string $path, array|string $handler, ?string $name = null): self
    {
        return $this->addRoute('POST', $path, $handler, $name);
    }
    
    /**
     * Register PUT route
     */
    public function put(string $path, array|string $handler, ?string $name = null): self
    {
        return $this->addRoute('PUT', $path, $handler, $name);
    }
    
    /**
     * Register DELETE route
     */
    public function delete(string $path, array|string $handler, ?string $name = null): self
    {
        return $this->addRoute('DELETE', $path, $handler, $name);
    }
    
    /**
     * Register PATCH route
     */
    public function patch(string $path, array|string $handler, ?string $name = null): self
    {
        return $this->addRoute('PATCH', $path, $handler, $name);
    }
    
    /**
     * Register route for any method
     */
    public function any(string $path, array|string $handler, ?string $name = null): self
    {
        $methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
        foreach ($methods as $method) {
            $this->addRoute($method, $path, $handler, $name);
        }
        return $this;
    }
    
    /**
     * Register RESTful resource routes
     */
    public function resource(string $name, string $controller): self
    {
        $basePath = '/' . trim($name, '/');
        
        $this->get($basePath, [$controller, 'index'], "{$name}.index");
        $this->get("{$basePath}/create", [$controller, 'create'], "{$name}.create");
        $this->post($basePath, [$controller, 'store'], "{$name}.store");
        $this->get("{$basePath}/{id}", [$controller, 'show'], "{$name}.show");
        $this->get("{$basePath}/{id}/edit", [$controller, 'edit'], "{$name}.edit");
        $this->put("{$basePath}/{id}", [$controller, 'update'], "{$name}.update");
        $this->delete("{$basePath}/{id}", [$controller, 'destroy'], "{$name}.destroy");
        
        return $this;
    }
    
    /**
     * Add route with middleware support
     */
    private function addRoute(string $method, string $path, array|string $handler, ?string $name = null): self
    {
        $path = '/' . trim($path, '/');
        if ($path === '/') {
            $path = '/';
        }
        
        // Parse handler
        if (is_string($handler)) {
            $handler = $this->parseHandler($handler);
        }
        
        $route = [
            'method' => $method,
            'path' => $path,
            'controller' => $handler[0],
            'action' => $handler[1],
            'middleware' => [],
            'regex' => $this->buildRegex($path),
        ];
        
        $this->routes[] = $route;
        $lastIndex = array_key_last($this->routes);
        
        if ($name !== null) {
            $this->namedRoutes[$name] = $lastIndex;
        }
        
        return $this;
    }
    
    /**
     * Parse handler string (format: "Controller@action")
     */
    private function parseHandler(string $handler): array
    {
        if (!str_contains($handler, '@')) {
            throw new \InvalidArgumentException("Invalid handler format: {$handler}");
        }
        
        [$controller, $action] = explode('@', $handler);
        
        // Add namespace if not present
        if (!str_contains($controller, '\\')) {
            $controller = "App\\Controllers\\{$controller}";
        }
        
        return [$controller, $action];
    }
    
    /**
     * Build regex pattern from route path
     */
    private function buildRegex(string $path): string
    {
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
    
    /**
     * Add middleware to last route
     */
    public function middleware(string|array $middleware): self
    {
        $lastIndex = array_key_last($this->routes);
        
        if ($lastIndex === null) {
            throw new \RuntimeException('No route defined to add middleware to');
        }
        
        $middleware = is_array($middleware) ? $middleware : [$middleware];
        
        $this->routes[$lastIndex]['middleware'] = array_merge(
            $this->routes[$lastIndex]['middleware'],
            $middleware
        );
        
        return $this;
    }
    
    /**
     * Match request to route
     */
    public function match(string $method, string $path): ?array
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            if (preg_match($route['regex'], $path, $matches)) {
                // Extract named parameters
                $params = [];
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                
                return [
                    'controller' => $route['controller'],
                    'action' => $route['action'],
                    'middleware' => $route['middleware'],
                    'params' => $params,
                ];
            }
        }
        
        return null;
    }
    
    /**
     * Generate URL for named route
     */
    public function url(string $name, array $params = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new \InvalidArgumentException("Route not found: {$name}");
        }
        
        $route = $this->routes[$this->namedRoutes[$name]];
        $path = $route['path'];
        
        foreach ($params as $key => $value) {
            $path = str_replace("{{$key}}", (string)$value, $path);
        }
        
        return $path;
    }
}
