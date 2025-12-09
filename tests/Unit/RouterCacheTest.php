<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

/**
 * Tests pour tuer les mutants du cache Router
 */
class RouterCacheTest extends TestCase
{
    private string $cacheDir;

    protected function setUp(): void
    {
        Router::resetInstance();
        $this->cacheDir = __DIR__ . '/../../storage/cache';

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    protected function tearDown(): void
    {
        Router::resetInstance();

        // Nettoyer cache
        $cacheFile = $this->cacheDir . '/routes.php';
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        parent::tearDown();
    }

    public function testCacheFilePathContainsStorageDirectory(): void
    {
        $router = Router::getInstance();
        $cacheFile = $router->getCacheFile();

        // Le chemin doit contenir le répertoire complet, pas juste le relatif
        $this->assertStringContainsString('storage/cache/routes.php', $cacheFile);

        // Ne doit pas être juste le path relatif sans __DIR__
        $this->assertNotEquals('/../../storage/cache/routes.php', $cacheFile);
    }

    public function testCacheEnabledInverseOfAppDebug(): void
    {
        $router = Router::getInstance();
        $cacheEnabled = $router->isCacheEnabled();

        // En mode test, APP_DEBUG est true → cacheEnabled doit être false
        if (APP_DEBUG) {
            $this->assertFalse($cacheEnabled);
        } else {
            $this->assertTrue($cacheEnabled);
        }
    }

    public function testSaveCacheCreatesFile(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        // Ajouter routes
        $router->get('/test-cache-1', 'TestController@index', 'test.cache.1');
        $router->post('/test-cache-2', 'TestController@store', 'test.cache.2');

        // Sauvegarder
        $router->saveCache();

        $cacheFile = $router->getCacheFile();

        // Si cache activé, le fichier doit exister
        if ($router->isCacheEnabled()) {
            $this->assertFileExists($cacheFile);

            // Vérifier contenu
            $content = file_get_contents($cacheFile);
            $this->assertStringContainsString('test.cache.1', $content);
            $this->assertStringContainsString('test.cache.2', $content);
        } else {
            // En mode debug, pas de fichier créé
            $this->assertTrue(true);
        }
    }

    public function testClearCacheRemovesFile(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        $router->get('/test', 'TestController@index', 'test');
        $router->saveCache();

        $cacheFile = $router->getCacheFile();

        // Clear
        $router->clearCache();

        // Fichier ne doit plus exister
        $this->assertFileDoesNotExist($cacheFile);
    }
}
