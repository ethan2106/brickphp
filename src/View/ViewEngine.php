<?php

declare(strict_types=1);

namespace BrickPHP\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use BrickPHP\Security\CsrfProtection;

/**
 * View Engine using Twig
 * 
 * Handles template rendering with security features.
 */
class ViewEngine
{
    private Environment $twig;
    private CsrfProtection $csrf;
    
    public function __construct(array $config)
    {
        $viewsPath = $config['path'] ?? __DIR__ . '/../../app/Views';
        $cachePath = $config['cache'] ?? __DIR__ . '/../../storage/cache/views';
        $debug = $config['debug'] ?? false;
        
        $loader = new FilesystemLoader($viewsPath);
        
        $this->twig = new Environment($loader, [
            'cache' => $debug ? false : $cachePath,
            'debug' => $debug,
            'autoescape' => 'html',
            'strict_variables' => true,
        ]);
        
        if ($debug) {
            $this->twig->addExtension(new DebugExtension());
        }
        
        $this->csrf = new CsrfProtection();
        $this->registerGlobalFunctions();
    }
    
    /**
     * Register global Twig functions
     */
    private function registerGlobalFunctions(): void
    {
        // CSRF token function
        $this->twig->addFunction(
            new \Twig\TwigFunction('csrf_field', function () {
                return $this->csrf->field();
            }, ['is_safe' => ['html']])
        );
        
        $this->twig->addFunction(
            new \Twig\TwigFunction('csrf_token', function () {
                return $this->csrf->generateToken();
            })
        );
        
        // URL generation function
        $this->twig->addFunction(
            new \Twig\TwigFunction('url', function (string $path) {
                return '/' . ltrim($path, '/');
            })
        );
        
        // Asset function
        $this->twig->addFunction(
            new \Twig\TwigFunction('asset', function (string $path) {
                return '/assets/' . ltrim($path, '/');
            })
        );
    }
    
    /**
     * Render template
     */
    public function render(string $template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }
    
    /**
     * Get Twig environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }
}
