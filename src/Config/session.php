<?php

/**
 * Gestion des sessions
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    // Configuration sécurisée des sessions
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_samesite', 'Lax');

    session_start();
}

// Génération du token CSRF si absent
if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] === '') {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Vérifie le token CSRF
 */
function verify_csrf(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Génère un input hidden CSRF
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token']) . '">';
}
