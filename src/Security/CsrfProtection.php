<?php

declare(strict_types=1);

namespace BrickPHP\Security;

/**
 * CSRF Protection
 * 
 * Protects against Cross-Site Request Forgery attacks.
 */
class CsrfProtection
{
    private const TOKEN_NAME = '_csrf_token';
    private const TOKEN_LENGTH = 32;
    
    /**
     * Generate CSRF token
     */
    public function generateToken(): string
    {
        if (!isset($_SESSION[self::TOKEN_NAME])) {
            $_SESSION[self::TOKEN_NAME] = bin2hex(random_bytes(self::TOKEN_LENGTH));
        }
        
        return $_SESSION[self::TOKEN_NAME];
    }
    
    /**
     * Get current CSRF token
     */
    public function getToken(): ?string
    {
        return $_SESSION[self::TOKEN_NAME] ?? null;
    }
    
    /**
     * Validate CSRF token
     */
    public function validateToken(string $token): bool
    {
        $sessionToken = $this->getToken();
        
        if ($sessionToken === null) {
            return false;
        }
        
        return hash_equals($sessionToken, $token);
    }
    
    /**
     * Get token field for forms
     */
    public function field(): string
    {
        $token = $this->generateToken();
        return sprintf(
            '<input type="hidden" name="%s" value="%s">',
            self::TOKEN_NAME,
            htmlspecialchars($token, ENT_QUOTES, 'UTF-8')
        );
    }
    
    /**
     * Get token meta tag for AJAX
     */
    public function meta(): string
    {
        $token = $this->generateToken();
        return sprintf(
            '<meta name="csrf-token" content="%s">',
            htmlspecialchars($token, ENT_QUOTES, 'UTF-8')
        );
    }
}
