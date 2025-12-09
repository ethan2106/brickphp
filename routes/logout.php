<?php

declare(strict_types=1);
/**
 * Route: Logout
 */

use App\Controller\AuthController;

$controller = new AuthController();
$controller->logout();
