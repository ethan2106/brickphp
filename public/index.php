<?php

declare(strict_types=1);

/**
 * BrickPHP SUPERCAR - Front Controller
 * 
 * This is the entry point for all requests to the application.
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

// Bootstrap application
$app = BrickPHP\Core\Application::getInstance();
$app->bootstrap(__DIR__ . '/../config');

// Load routes
require_once __DIR__ . '/../routes/web.php';

// Run application
$app->run();
