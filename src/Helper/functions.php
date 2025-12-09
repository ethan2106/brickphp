<?php

/**
 * Fonctions helper globales
 *
 * CORRECTIONS APPLIQUÉES (v1.1):
 * - csrf() : génère un champ hidden avec le token CSRF
 * - current_path() : Windows path compatibility
 */

declare(strict_types=1);

/**
 * Génère un champ hidden avec le token CSRF
 * Usage: <?php csrf(); ?>
 */
function csrf(): void
{
    $token = $_SESSION['csrf_token'] ?? '';
    echo '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
}

/**
 * Récupère le token CSRF actuel
 */
function csrf_token(): string
{
    return $_SESSION['csrf_token'] ?? '';
}

/**
 * Inclut un composant réutilisable
 *
 * @param string $name Nom du composant (sans .php)
 * @param array $data Variables à passer au composant
 */
function component(string $name, array $data = []): void
{
    extract($data);
    $path = __DIR__ . "/../View/components/{$name}.php";

    if (file_exists($path)) {
        require $path;
    } else {
        echo "<!-- Composant '{$name}' non trouvé -->";
    }
}

/**
 * Échappe une chaîne pour affichage HTML
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Génère une URL pour une route nommée
 *
 * @param string $name Nom de la route (ex: 'login', 'user.show')
 * @param array $params Paramètres dynamiques (ex: ['id' => 5])
 */
function url(string $name, array $params = []): string
{
    return \App\Core\Router::getInstance()->url($name, $params);
}

/**
 * Affiche une URL vers une route (echo automatique)
 */
function route(string $name, array $params = []): void
{
    echo url($name, $params);
}

/**
 * Récupère le path actuel de la requête
 */
function current_path(): string
{
    $parsedPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = $parsedPath !== false && $parsedPath !== null ? $parsedPath : '/';
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);

    // FIX: Normaliser les slashes pour Windows
    $scriptDir = str_replace('\\', '/', $scriptDir);

    if ($scriptDir !== '/' && str_starts_with($path, $scriptDir)) {
        $path = substr($path, strlen($scriptDir));
    }

    return $path !== '' ? $path : '/';
}

/**
 * Vérifie si on est sur une route donnée
 *
 * @param string $routeName Nom de la route (ex: 'home', 'components')
 */
function is_route(string $routeName): bool
{
    try {
        $routePath = url($routeName);

        return current_path() === $routePath;
    } catch (\Exception $e) {
        return false;
    }
}

/**
 * Retourne une classe si on est sur la route
 */
function active_class(string $routeName, string $class = 'active'): string
{
    return is_route($routeName) ? $class : '';
}

/**
 * Dump and die (debug)
 */
function dd(mixed ...$vars): never
{
    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
    die();
}

/**
 * Récupère une variable d'environnement ou valeur par défaut
 */
function env(string $key, mixed $default = null): mixed
{
    return $_ENV[$key] ?? $default;
}

/**
 * Formate une date
 */
function format_date(string $date, string $format = 'd/m/Y'): string
{
    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return $date;
    }

    return date($format, $timestamp);
}

/**
 * Tronque un texte
 */
function truncate(string $text, int $length = 100, string $suffix = '...'): string
{
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . $suffix;
}
