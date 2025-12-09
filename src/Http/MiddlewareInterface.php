<?php

declare(strict_types=1);

namespace BrickPHP\Http;

/**
 * Middleware Interface
 */
interface MiddlewareInterface
{
    /**
     * Handle request and return response or null to continue
     */
    public function handle(Request $request): ?Response;
}
