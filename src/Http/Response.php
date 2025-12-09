<?php

declare(strict_types=1);

namespace BrickPHP\Http;

/**
 * HTTP Response Class
 * 
 * Represents an HTTP response with security headers.
 */
class Response
{
    private string $content;
    private int $statusCode;
    private array $headers = [];
    
    private const STATUS_TEXTS = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        304 => 'Not Modified',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        422 => 'Unprocessable Entity',
        500 => 'Internal Server Error',
        503 => 'Service Unavailable',
    ];
    
    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = array_merge($this->getDefaultSecurityHeaders(), $headers);
    }
    
    /**
     * Get default security headers
     */
    private function getDefaultSecurityHeaders(): array
    {
        return [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';",
        ];
    }
    
    /**
     * Set response content
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * Get response content
     */
    public function getContent(): string
    {
        return $this->content;
    }
    
    /**
     * Set status code
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    
    /**
     * Get status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    
    /**
     * Set header
     */
    public function setHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }
    
    /**
     * Get header
     */
    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }
    
    /**
     * Get all headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
    
    /**
     * Send response to client
     */
    public function send(): void
    {
        $this->sendHeaders();
        $this->sendContent();
    }
    
    /**
     * Send headers
     */
    private function sendHeaders(): void
    {
        if (headers_sent()) {
            return;
        }
        
        // Send status line
        $statusText = self::STATUS_TEXTS[$this->statusCode] ?? 'Unknown';
        header("HTTP/1.1 {$this->statusCode} {$statusText}");
        
        // Send headers
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
    }
    
    /**
     * Send content
     */
    private function sendContent(): void
    {
        echo $this->content;
    }
    
    /**
     * Create JSON response
     */
    public static function json(array $data, int $statusCode = 200): self
    {
        $content = json_encode($data, JSON_THROW_ON_ERROR);
        
        return new self($content, $statusCode, [
            'Content-Type' => 'application/json',
        ]);
    }
    
    /**
     * Create redirect response
     */
    public static function redirect(string $url, int $statusCode = 302): self
    {
        return new self('', $statusCode, [
            'Location' => $url,
        ]);
    }
    
    /**
     * Create HTML response
     */
    public static function html(string $html, int $statusCode = 200): self
    {
        return new self($html, $statusCode, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }
}
