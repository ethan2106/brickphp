<?php

declare(strict_types=1);
/**
 * Route: Login
 */

use App\Controller\AuthController;

$controller = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} else {
    $controller->loginForm();
}
