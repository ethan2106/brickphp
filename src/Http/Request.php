<?php

declare(strict_types=1);

namespace BrickPHP\Http;

/**
 * HTTP Request Class
 * 
 * Represents an HTTP request with security features.
 */
class Request
{
    private string $method;
    private string $path;
    private array $query;
    private array $post;
    private array $files;
    private array $server;
    private array $headers;
    private ?string $body;
    
    public function __construct(
        string $method,
        string $path,
        array $query = [],
        array $post = [],
        array $files = [],
        array $server = [],
        ?string $body = null
    ) {
        $this->method = strtoupper($method);
        $this->path = $this->sanitizePath($path);
        $this->query = $query;
        $this->post = $post;
        $this->files = $files;
        $this->server = $server;
        $this->body = $body;
        $this->headers = $this->parseHeaders($server);
    }
    
    /**
     * Create request from PHP globals
     */
    public static function createFromGlobals(): self
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        
        $body = null;
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $body = file_get_contents('php://input');
        }
        
        return new self(
            $method,
            $path,
            $_GET,
            $_POST,
            $_FILES,
            $_SERVER,
            $body
        );
    }
    
    /**
     * Sanitize path to prevent directory traversal
     */
    private function sanitizePath(string $path): string
    {
        $path = preg_replace('#/+#', '/', $path);
        $path = rtrim($path, '/') ?: '/';
        
        // Remove any .. to prevent directory traversal
        $parts = explode('/', $path);
        $safe = [];
        
        foreach ($parts as $part) {
            if ($part === '..' || $part === '.') {
                continue;
            }
            $safe[] = $part;
        }
        
        return '/' . implode('/', array_filter($safe));
    }
    
    /**
     * Parse headers from server array
     */
    private function parseHeaders(array $server): array
    {
        $headers = [];
        
        foreach ($server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $header = str_replace('_', '-', substr($key, 5));
                $headers[$header] = $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH'])) {
                $header = str_replace('_', '-', $key);
                $headers[$header] = $value;
            }
        }
        
        return $headers;
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
    
    public function getPath(): string
    {
        return $this->path;
    }
    
    /**
     * Get query parameter with XSS protection
     */
    public function query(string $key, mixed $default = null): mixed
    {
        $value = $this->query[$key] ?? $default;
        return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }
    
    /**
     * Get all query parameters
     */
    public function allQuery(): array
    {
        return $this->query;
    }
    
    /**
     * Get POST parameter with XSS protection
     */
    public function post(string $key, mixed $default = null): mixed
    {
        $value = $this->post[$key] ?? $default;
        return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }
    
    /**
     * Get all POST parameters
     */
    public function allPost(): array
    {
        return $this->post;
    }
    
    /**
     * Get input from query or post
     */
    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post($key) ?? $this->query($key, $default);
    }
    
    /**
     * Get all inputs
     */
    public function all(): array
    {
        return array_merge($this->query, $this->post);
    }
    
    /**
     * Get header value
     */
    public function header(string $key, ?string $default = null): ?string
    {
        $key = strtoupper(str_replace('-', '_', $key));
        return $this->headers[$key] ?? $default;
    }
    
    /**
     * Get request body
     */
    public function getBody(): ?string
    {
        return $this->body;
    }
    
    /**
     * Get JSON body as array
     */
    public function json(): ?array
    {
        if ($this->body === null) {
            return null;
        }
        
        $data = json_decode($this->body, true);
        return is_array($data) ? $data : null;
    }
    
    /**
     * Check if request is AJAX
     */
    public function isAjax(): bool
    {
        return $this->header('X-Requested-With') === 'XMLHttpRequest';
    }
    
    /**
     * Check if request is JSON
     */
    public function isJson(): bool
    {
        $contentType = $this->header('Content-Type') ?? '';
        return str_contains($contentType, 'application/json');
    }
    
    /**
     * Get uploaded file
     */
    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }
    
    /**
     * Validate CSRF token
     */
    public function validateCsrf(string $sessionToken): bool
    {
        $token = $this->post('_csrf_token') ?? $this->header('X-CSRF-Token');
        return $token !== null && hash_equals($sessionToken, $token);
    }
}
