<?php

declare(strict_types=1);

namespace App\Middleware;

use BrickPHP\Http\MiddlewareInterface;
use BrickPHP\Http\Request;
use BrickPHP\Http\Response;
use BrickPHP\Security\CsrfProtection;
use BrickPHP\Core\Application;

/**
 * CSRF Middleware
 * 
 * Validates CSRF tokens for POST, PUT, PATCH, DELETE requests.
 */
class CsrfMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): ?Response
    {
        $method = $request->getMethod();
        
        // Skip CSRF validation for GET and HEAD requests
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
            return null;
        }
        
        $csrf = Application::getInstance()
            ->getContainer()
            ->make(CsrfProtection::class);
        
        $token = $csrf->getToken();
        
        if ($token === null || !$request->validateCsrf($token)) {
            return new Response('CSRF token validation failed', 403);
        }
        
        return null;
    }
}
