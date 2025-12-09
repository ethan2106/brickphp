<?php

/**
 * Service de rendu de vues - Support PHP natif + Twig
 *
 * Permet de basculer entre les vues PHP classiques et Twig
 * pour une migration progressive et flexible.
 */

declare(strict_types=1);

namespace App\Service;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class ViewService
{
    private static ?Environment $twig = null;
    private static ?ViewService $instance = null;

    private function __construct()
    {
        $this->initializeTwig();
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    /**
     * Initialise Twig avec configuration optimisée
     */
    private function initializeTwig(): void
    {
        $loader = new FilesystemLoader(__DIR__ . '/../View');

        $options = [
            'autoescape' => 'html',
            'strict_variables' => APP_DEBUG,
        ];

        // Cache seulement en production
        if (!APP_DEBUG) {
            $cacheDir = __DIR__ . '/../../storage/cache/twig';
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }
            $options['cache'] = $cacheDir;
        }

        self::$twig = new Environment($loader, $options);

        // Fonctions globales et helpers
        $this->addGlobals();
        $this->addFunctions();
        $this->addFilters();
    }

    /**
     * Ajoute les variables globales
     */
    private function addGlobals(): void
    {
        assert(self::$twig !== null, 'Twig should be initialized');
        self::$twig->addGlobal('app_name', APP_NAME);
        self::$twig->addGlobal('app_url', APP_URL);
        self::$twig->addGlobal('app_debug', APP_DEBUG);
        self::$twig->addGlobal('csrf_token', csrf_token());
        self::$twig->addGlobal('app', [
            'session' => $_SESSION,
            'name' => APP_NAME,
            'url' => APP_URL,
            'debug' => APP_DEBUG,
        ]);
    }

    /**
     * Ajoute les fonctions Twig
     */
    private function addFunctions(): void
    {
        assert(self::$twig !== null, 'Twig should be initialized');
        // Helpers existants
        self::$twig->addFunction(new TwigFunction('url', 'url'));
        self::$twig->addFunction(new TwigFunction('route', 'route'));
        self::$twig->addFunction(new TwigFunction('is_route', 'is_route'));
        self::$twig->addFunction(new TwigFunction('component', 'component'));

        // Utilitaires
        self::$twig->addFunction(new TwigFunction('current_path', 'current_path'));
        self::$twig->addFunction(new TwigFunction('csrf', function () { csrf(); }));
    }

    /**
     * Ajoute les filtres personnalisés
     */
    private function addFilters(): void
    {
        assert(self::$twig !== null, 'Twig should be initialized');
        // Filtre pour formater les dates
        self::$twig->addFilter(new \Twig\TwigFilter('date_fr', function ($date) {
            return date('d/m/Y', strtotime($date));
        }));

        // Filtre pour tronquer le texte
        self::$twig->addFilter(new \Twig\TwigFilter('truncate', function ($text, $length = 100) {
            if (strlen($text) <= $length) {
                return $text;
            }

            return substr($text, 0, $length) . '...';
        }));
    }

    /**
     * Rend une vue Twig
     */
    public function render(string $template, array $data = []): string
    {
        if (self::$twig === null) {
            throw new \RuntimeException('Twig n\'est pas initialisé.');
        }

        return self::$twig->render($template . '.twig', $data);
    }

    /**
     * Rend une vue PHP classique (fallback)
     */
    public function renderPhp(string $template, array $data = []): void
    {
        extract($data);
        $path = __DIR__ . '/../View/' . $template . '.php';

        if (!file_exists($path)) {
            throw new \RuntimeException("Vue '{$template}' introuvable.");
        }

        require $path;
    }

    /**
     * Vérifie si Twig est disponible
     */
    public static function hasTwig(): bool
    {
        return class_exists('Twig\Environment');
    }

    /**
     * Nettoie le cache Twig
     */
    public function clearCache(): void
    {
        if (self::$twig !== null) {
            $cache = self::$twig->getCache();
            if ($cache !== false && is_string($cache) && is_dir($cache)) {
                $this->rmdirRecursive($cache);
                mkdir($cache, 0755, true);
            }
        }
    }

    private function rmdirRecursive(string $dir): void
    {
        $scanResult = scandir($dir);
        if ($scanResult === false) {
            return;
        }
        $files = array_diff($scanResult, ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            is_dir($path) ? $this->rmdirRecursive($path) : unlink($path);
        }
        rmdir($dir);
    }
}
