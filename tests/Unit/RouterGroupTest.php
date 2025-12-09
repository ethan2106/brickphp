<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

/**
 * Tests pour tuer mutants de group() (prefix + middleware stack)
 */
class RouterGroupTest extends TestCase
{
    protected function setUp(): void
    {
        Router::resetInstance();
    }

    protected function tearDown(): void
    {
        Router::resetInstance();
        parent::tearDown();
    }

    public function testGroupWithPrefixAndMiddleware(): void
    {
        $router = Router::getInstance();

        $router->group(['prefix' => '/admin', 'middleware' => ['auth']], function ($r) {
            $r->get('/dashboard', 'AdminController@dashboard', 'admin.dashboard');
            $r->post('/users', 'AdminController@createUser', 'admin.users.create');
        });

        // Vérifie que le prefix est bien appliqué
        $this->assertSame('/admin/dashboard', $router->url('admin.dashboard'));
        $this->assertSame('/admin/users', $router->url('admin.users.create'));

        // Vérifie que le middleware est dans la route
        $routes = $router->getRoutes();
        $dashboardRoute = $routes['GET'][0];

        $this->assertContains('auth', $dashboardRoute['middleware']);
    }

    public function testGroupWithEmptyPrefixUsesEmptyString(): void
    {
        $router = Router::getInstance();

        $router->group([], function ($r) {
            $r->get('/test', 'TestController@index', 'test');
        });

        $url = $router->url('test');
        $this->assertEquals('/test', $url);
    }

    public function testGroupWithoutMiddlewareUsesEmptyArray(): void
    {
        $router = Router::getInstance();

        $router->group(['prefix' => '/blog'], function ($r) {
            $r->get('/posts', 'BlogController@index', 'blog.posts');
        });

        $routes = $router->getRoutes();
        $route = $routes['GET'][0];

        // Middleware doit être un array vide
        $this->assertIsArray($route['middleware']);
        $this->assertEmpty($route['middleware']);
    }

    public function testGroupMiddlewareAsStringIsConvertedToArray(): void
    {
        $router = Router::getInstance();

        // Middleware en string
        $router->group(['middleware' => 'csrf'], function ($r) {
            $r->post('/form', 'FormController@submit', 'form.submit');
        });

        $routes = $router->getRoutes();
        $route = $routes['POST'][0];

        // Doit être converti en array
        $this->assertIsArray($route['middleware']);
        $this->assertContains('csrf', $route['middleware']);
    }

    public function testNestedGroupsMergeMiddlewareCorrectly(): void
    {
        $router = Router::getInstance();

        $router->group(['middleware' => ['outer1', 'outer2']], function ($r) {
            $r->group(['middleware' => ['inner']], function ($r2) {
                $r2->get('/nested', 'NestedController@index', 'nested');
            });
        });

        $routes = $router->getRoutes();
        $route = $routes['GET'][0];
        $middleware = $route['middleware'];

        // Doit contenir outer1, outer2, inner dans l'ordre (array_merge)
        $this->assertEquals(['outer1', 'outer2', 'inner'], $middleware);
    }

    public function testNestedGroupsMergePrefixesCorrectly(): void
    {
        $router = Router::getInstance();

        $router->group(['prefix' => '/api'], function ($r) {
            $r->group(['prefix' => '/v1'], function ($r2) {
                $r2->get('/users', 'ApiController@users', 'api.v1.users');
            });
        });

        $url = $router->url('api.v1.users');
        $this->assertEquals('/api/v1/users', $url);
    }

    public function testGroupStackIsRestoredAfterCallback(): void
    {
        $router = Router::getInstance();

        // Premier groupe
        $router->group(['prefix' => '/admin'], function ($r) {
            $r->get('/dashboard', 'AdminController@dashboard', 'admin.dashboard');
        });

        // Route hors groupe (ne doit pas avoir le prefix)
        $router->get('/public', 'PublicController@index', 'public');

        $this->assertEquals('/admin/dashboard', $router->url('admin.dashboard'));
        $this->assertEquals('/public', $router->url('public'));
    }

    public function testMiddlewareStackIsRestoredAfterCallback(): void
    {
        $router = Router::getInstance();

        // Groupe avec middleware
        $router->group(['middleware' => ['auth']], function ($r) {
            $r->get('/protected', 'SecureController@index', 'protected');
        });

        // Route hors groupe (pas de middleware)
        $router->get('/open', 'OpenController@index', 'open');

        $routes = $router->getRoutes();

        $protectedRoute = $routes['GET'][0];
        $this->assertContains('auth', $protectedRoute['middleware']);

        $openRoute = $routes['GET'][1];
        $this->assertEmpty($openRoute['middleware']);
    }
}
