<?php

declare(strict_types=1);

use BrickPHP\Core\Application;
use BrickPHP\Http\Response;

if (!function_exists('app')) {
    /**
     * Get application instance
     */
    function app(): Application
    {
        return Application::getInstance();
    }
}

if (!function_exists('config')) {
    /**
     * Get configuration value
     */
    function config(string $key, mixed $default = null): mixed
    {
        return app()->config($key, $default);
    }
}

if (!function_exists('env')) {
    /**
     * Get environment variable
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        
        if ($value === false) {
            return $default;
        }
        
        // Convert string booleans
        return match (strtolower((string)$value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'null', '(null)' => null,
            'empty', '(empty)' => '',
            default => $value,
        };
    }
}

if (!function_exists('view')) {
    /**
     * Render view template
     */
    function view(string $template, array $data = []): Response
    {
        $viewEngine = app()->getContainer()->make(\BrickPHP\View\ViewEngine::class);
        $content = $viewEngine->render($template, $data);
        return Response::html($content);
    }
}

if (!function_exists('redirect')) {
    /**
     * Create redirect response
     */
    function redirect(string $url, int $statusCode = 302): Response
    {
        return Response::redirect($url, $statusCode);
    }
}

if (!function_exists('json')) {
    /**
     * Create JSON response
     */
    function json(array $data, int $statusCode = 200): Response
    {
        return Response::json($data, $statusCode);
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get CSRF token
     */
    function csrf_token(): string
    {
        $csrf = app()->getContainer()->make(\BrickPHP\Security\CsrfProtection::class);
        return $csrf->generateToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF field HTML
     */
    function csrf_field(): string
    {
        $csrf = app()->getContainer()->make(\BrickPHP\Security\CsrfProtection::class);
        return $csrf->field();
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and die (for debugging)
     */
    function dd(mixed ...$vars): never
    {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        die(1);
    }
}

if (!function_exists('sanitize')) {
    /**
     * Sanitize string (XSS protection)
     */
    function sanitize(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
