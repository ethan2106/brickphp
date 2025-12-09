<?php

/**
 * Configuration de l'application
 */

declare(strict_types=1);

// Mode debug (désactiver en production)
define('APP_DEBUG', true);

// Nom de l'application
define('APP_NAME', 'Mon Application');

// URL de base (ajuster selon environnement)
define('APP_URL', 'http://localhost/MVC/public');

// Router: utilise le système de routes centralisé (routes/web.php)
define('USE_ROUTER', true);

// Timezone
date_default_timezone_set('Europe/Paris');

// Affichage des erreurs (selon debug)
/** @phpstan-ignore-next-line */
error_reporting(APP_DEBUG ? E_ALL : 0);
/** @phpstan-ignore-next-line */
ini_set('display_errors', APP_DEBUG ? '1' : '0');

// Configuration Base de données
define('DB_DRIVER', 'sqlite');
define('DB_HOST', 'localhost');
define('DB_NAME', ':memory:');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
