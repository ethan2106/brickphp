<?php
/**
 * Front Controller - Point d'entrée unique
 */

declare(strict_types=1);

// Autoload Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Configuration
require_once __DIR__ . '/../src/Config/app.php';
require_once __DIR__ . '/../src/Config/session.php';

// Helpers globaux
require_once __DIR__ . '/../src/Helper/functions.php';

// Chargement et exécution du Router
$router = require_once __DIR__ . '/../routes/web.php';
$router->dispatch();
