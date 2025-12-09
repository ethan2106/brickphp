<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

/**
 * Tests pour tuer mutants spécifiques Infection
 */
class RouterMutationTest extends TestCase
{
    protected function tearDown(): void
    {
        Router::resetInstance();
        parent::tearDown();
    }

    public function testCacheFilePathIsCorrect(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        // Utiliser reflection pour vérifier le chemin du cache
        $reflection = new \ReflectionClass($router);
        $property = $reflection->getProperty('cacheFile');
        $property->setAccessible(true);
        $cacheFile = $property->getValue($router);

        // Le chemin doit contenir __DIR__ et se terminer par routes.php
        $this->assertStringContainsString('storage/cache/routes.php', $cacheFile);
        $this->assertNotEquals('/../../storage/cache/routes.php', $cacheFile);
    }

    public function testCacheEnabledInverseOfAppDebug(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        $reflection = new \ReflectionClass($router);
        $property = $reflection->getProperty('cacheEnabled');
        $property->setAccessible(true);
        $cacheEnabled = $property->getValue($router);

        // En mode test, APP_DEBUG est true → cacheEnabled doit être false
        if (APP_DEBUG) {
            $this->assertFalse($cacheEnabled);
        } else {
            $this->assertTrue($cacheEnabled);
        }
    }

    public function testGroupWithEmptyPrefix(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        $router->group([], function ($r) {
            $r->get('/test', 'TestController@index', 'test');
        });

        $url = $router->url('test');
        $this->assertEquals('/test', $url);
    }

    public function testGroupMiddlewareArrayMerge(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        // Tester que array_merge fonctionne correctement
        $router->group(['middleware' => ['a', 'b']], function ($r) {
            $r->group(['middleware' => ['c']], function ($r2) {
                $r2->get('/deep', 'DeepController@index');
            });
        });

        $routes = $router->getRoutes();
        $route = $routes['GET'][count($routes['GET']) - 1];

        // Doit contenir a, b, c dans l'ordre
        $this->assertEquals(['a', 'b', 'c'], $route['middleware']);
    }

    public function testPathPatternWithEmptySegment(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        // Route avec double slash → doit être normalisée
        $router->get('///users///{id}', 'UserController@show', 'user', ['id' => '\d+']);

        $url = $router->url('user', ['id' => 42]);
        // Devrait être normalisé en /users/42
        $this->assertStringContainsString('users', $url);
        $this->assertStringContainsString('42', $url);
    }

    public function testConstraintAppliesCorrectly(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        $router->get('/posts/{id}/{slug}', 'PostController@show', 'post', [
            'id' => '\d+',
            'slug' => '[a-z-]+',
        ]);

        $routes = $router->getRoutes();
        $pattern = $routes['GET'][0]['pattern'];

        // Le pattern doit contenir les contraintes
        $this->assertStringContainsString('\d+', $pattern);
        $this->assertStringContainsString('[a-z-]+', $pattern);
    }

    public function testRoutePathStoredCorrectly(): void
    {
        Router::resetInstance();
        $router = Router::getInstance();

        $router->get('/api/v1/users', 'ApiController@users', 'api.users');

        $routes = $router->getRoutes();
        $route = $routes['GET'][0];

        // La clé 'path' doit exister et correspondre
        $this->assertArrayHasKey('path', $route);
        $this->assertEquals('/api/v1/users', $route['path']);
    }
}
