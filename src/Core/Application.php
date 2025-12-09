<?php

declare(strict_types=1);

namespace BrickPHP\Core;

use BrickPHP\Http\Request;
use BrickPHP\Http\Response;
use BrickPHP\Routing\Router;
use BrickPHP\Database\Database;
use BrickPHP\View\ViewEngine;
use BrickPHP\Security\CsrfProtection;

/**
 * Main Application Class
 * 
 * Core application container that manages routing, request handling,
 * and dependency injection.
 */
class Application
{
    private static ?Application $instance = null;
    private Container $container;
    private Router $router;
    private array $config = [];
    
    private function __construct()
    {
        $this->container = new Container();
        $this->router = new Router();
    }
    
    /**
     * Get singleton instance
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Bootstrap the application
     */
    public function bootstrap(string $configPath): self
    {
        // Load configuration
        $this->loadConfiguration($configPath);
        
        // Register core services
        $this->registerCoreServices();
        
        // Start session with security settings
        $this->startSecureSession();
        
        return $this;
    }
    
    /**
     * Load configuration files
     */
    private function loadConfiguration(string $configPath): void
    {
        if (!is_dir($configPath)) {
            throw new \RuntimeException("Configuration directory not found: {$configPath}");
        }
        
        foreach (glob($configPath . '/*.php') as $file) {
            $key = basename($file, '.php');
            $this->config[$key] = require $file;
        }
    }
    
    /**
     * Register core services in container
     */
    private function registerCoreServices(): void
    {
        // Register Database
        $this->container->singleton(Database::class, function () {
            $config = $this->config['database'] ?? [];
            return new Database($config);
        });
        
        // Register View Engine
        $this->container->singleton(ViewEngine::class, function () {
            $config = $this->config['view'] ?? [];
            return new ViewEngine($config);
        });
        
        // Register CSRF Protection
        $this->container->singleton(CsrfProtection::class, function () {
            return new CsrfProtection();
        });
    }
    
    /**
     * Start secure session
     */
    private function startSecureSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_only_cookies', '1');
            ini_set('session.cookie_secure', $this->config['app']['https'] ?? '0');
            ini_set('session.cookie_samesite', 'Strict');
            
            session_start();
        }
    }
    
    /**
     * Get router instance
     */
    public function getRouter(): Router
    {
        return $this->router;
    }
    
    /**
     * Get container instance
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
    
    /**
     * Get configuration value
     */
    public function config(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    /**
     * Handle HTTP request
     */
    public function handleRequest(Request $request): Response
    {
        try {
            $route = $this->router->match($request->getMethod(), $request->getPath());
            
            if ($route === null) {
                return new Response('Not Found', 404);
            }
            
            // Execute middleware
            $response = $this->executeMiddleware($route, $request);
            
            if ($response !== null) {
                return $response;
            }
            
            // Execute controller action
            return $this->executeController($route, $request);
            
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }
    
    /**
     * Execute middleware chain
     */
    private function executeMiddleware(array $route, Request $request): ?Response
    {
        $middleware = $route['middleware'] ?? [];
        
        foreach ($middleware as $middlewareClass) {
            $instance = $this->container->make($middlewareClass);
            $response = $instance->handle($request);
            
            if ($response !== null) {
                return $response;
            }
        }
        
        return null;
    }
    
    /**
     * Execute controller action
     */
    private function executeController(array $route, Request $request): Response
    {
        $controller = $this->container->make($route['controller']);
        $action = $route['action'];
        $params = $route['params'] ?? [];
        
        $result = $controller->$action($request, ...$params);
        
        if ($result instanceof Response) {
            return $result;
        }
        
        return new Response((string)$result);
    }
    
    /**
     * Handle exceptions
     */
    private function handleException(\Throwable $e): Response
    {
        $debug = $this->config('app.debug', false);
        
        if ($debug) {
            $content = sprintf(
                "<h1>Error: %s</h1><pre>%s</pre><pre>%s</pre>",
                $e->getMessage(),
                $e->getTraceAsString(),
                $e->getFile() . ':' . $e->getLine()
            );
            return new Response($content, 500);
        }
        
        return new Response('Internal Server Error', 500);
    }
    
    /**
     * Run the application
     */
    public function run(): void
    {
        $request = Request::createFromGlobals();
        $response = $this->handleRequest($request);
        $response->send();
    }
}
