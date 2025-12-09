<?php

/**
 * Définition des routes de l'application
 *
 * Syntaxes supportées:
 * - $router->get('/path', [Controller::class, 'method'], 'route.name')
 * - $router->post('/path', 'Controller@method')
 * - $router->any('/path', [...])  // GET + POST
 * - $router->group(['prefix' => '/admin', 'middleware' => ['auth']], function($router) { ... })
 */

declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\ComponentsController;
use App\Controller\HomeController;
use App\Controller\QuickstartController;
use App\Core\Router;

$router = Router::getInstance();

// ===============================
// Routes publiques
// ===============================

$router->get('/', [HomeController::class, 'index'], 'home');
$router->get('/home', [HomeController::class, 'index']);

$router->get('/components', [ComponentsController::class, 'index'], 'components');
$router->get('/quickstart', [QuickstartController::class, 'index'], 'quickstart');

// ===============================
// Authentification (invités seulement)
// ===============================

$router->group(['middleware' => ['guest']], function (Router $router) {
    $router->get('/login', [AuthController::class, 'loginForm'], 'login');
    $router->post('/login', [AuthController::class, 'login'], 'login.submit');

    $router->get('/register', [AuthController::class, 'registerForm'], 'register');
    $router->post('/register', [AuthController::class, 'register'], 'register.submit');
});

// Logout (authentifié seulement)
$router->group(['middleware' => ['auth']], function (Router $router) {
    $router->any('/logout', [AuthController::class, 'logout'], 'logout');
});

// ===============================
// Routes protégées (exemple)
// ===============================

// $router->group(['prefix' => '/dashboard', 'middleware' => ['auth']], function (Router $router) {
//     $router->get('/', [DashboardController::class, 'index'], 'dashboard');
//     $router->get('/profile', [ProfileController::class, 'show'], 'profile');
//     $router->post('/profile', [ProfileController::class, 'update'], 'profile.update');
// });

// Save routes to cache for performance
$router->saveCache();

return $router;
