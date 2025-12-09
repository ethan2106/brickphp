<?php

declare(strict_types=1);
/**
 * Route: Register
 */

use App\Controller\AuthController;

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register();
} else {
    $controller->registerForm();
}
