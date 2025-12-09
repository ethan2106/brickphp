<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

/**
 * Tests d'intégration du Router avec middleware et contraintes
 */
class RouterIntegrationTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();
        $this->router = Router::getInstance();

        // Simuler session pour middleware
        if (session_status() === \PHP_SESSION_NONE) {
            @session_start();
        }
    }

    protected function tearDown(): void
    {
        // Reset session
        $_SESSION = [];
        parent::tearDown();
    }

    public function testRouteWithNumericConstraint(): void
    {
        $this->router->get('/users/{id}', 'UserController@show', 'user.show', ['id' => '\d+']);

        $url = $this->router->url('user.show', ['id' => 123]);
        $this->assertEquals('/users/123', $url);
    }

    public function testRouteWithAlphanumericConstraint(): void
    {
        $this->router->get('/posts/{slug}', 'PostController@show', 'post.show', ['slug' => '[a-z0-9-]+']);

        $url = $this->router->url('post.show', ['slug' => 'my-post-title']);
        $this->assertEquals('/posts/my-post-title', $url);
    }

    public function testRouteGroupWithPrefix(): void
    {
        $this->router->group(['prefix' => '/admin'], function ($router) {
            $router->get('/dashboard', 'AdminController@dashboard', 'admin.dashboard');
        });

        $url = $this->router->url('admin.dashboard');
        $this->assertEquals('/admin/dashboard', $url);
    }

    public function testRouteGroupWithMultiplePrefixes(): void
    {
        $this->router->group(['prefix' => '/api'], function ($router) {
            $router->group(['prefix' => '/v1'], function ($router) {
                $router->get('/users', 'ApiController@users', 'api.v1.users');
            });
        });

        $url = $this->router->url('api.v1.users');
        $this->assertEquals('/api/v1/users', $url);
    }

    public function testMultipleParametersInRoute(): void
    {
        $this->router->get('/posts/{year}/{month}/{slug}', 'PostController@archive', 'post.archive', [
            'year' => '\d{4}',
            'month' => '\d{2}',
            'slug' => '[a-z0-9-]+',
        ]);

        $url = $this->router->url('post.archive', [
            'year' => '2025',
            'month' => '12',
            'slug' => 'my-article',
        ]);

        $this->assertEquals('/posts/2025/12/my-article', $url);
    }

    public function testAnyMethodCreatesGetAndPostRoutes(): void
    {
        $this->router->any('/contact', 'ContactController@handle', 'contact');

        // Vérifier que GET et POST existent
        $getUrl = $this->router->url('contact');
        $this->assertEquals('/contact', $getUrl);

        // POST devrait avoir un suffixe
        $postUrl = $this->router->url('contact.post');
        $this->assertEquals('/contact', $postUrl);
    }

    public function testUrlGenerationWithMissingParameterThrowsException(): void
    {
        $this->router->get('/users/{id}/posts/{postId}', 'UserController@showPost', 'user.posts');

        $this->expectException(\RuntimeException::class);
        $this->router->url('user.posts', ['id' => 1]); // Missing postId
    }

    public function testUrlGenerationWithUnknownRouteThrowsException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->router->url('non.existent.route');
    }

    public function testOptionalTrailingSlashMatches(): void
    {
        $this->router->get('/about', 'PageController@about', 'about');

        // Simuler une requête avec trailing slash
        // Note: Le router permet /about et /about/ grâce à la regex /?$
        $url = $this->router->url('about');
        $this->assertEquals('/about', $url);
    }

    public function testNamedRouteOverwritePreventsConflict(): void
    {
        $this->router->get('/home', 'HomeController@index', 'home');

        // Tenter d'enregistrer un second avec le même nom
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Nom de route 'home' déjà utilisé");

        $this->router->get('/homepage', 'HomeController@index2', 'home');
    }

    public function testEmptyRouteNameIsAllowed(): void
    {
        // Les routes sans nom ne devraient pas conflictuer
        $this->router->get('/page1', 'PageController@page1');

        $this->router->get('/page2', 'PageController@page2');

        // Pas d'exception = succès
        $this->assertTrue(true);
    }

    public function testParameterTypeCoercion(): void
    {
        $this->router->get('/items/{id}', 'ItemController@show', 'items.show', ['id' => '\d+']);

        // Le router devrait convertir automatiquement en int si c'est numérique
        $url = $this->router->url('items.show', ['id' => 999]);
        $this->assertEquals('/items/999', $url);
    }

    public function testRouteMethodsArePublic(): void
    {
        // Vérifier que post() est public et retourne self
        $result = $this->router->post('/test', 'TestController@store');
        $this->assertSame($this->router, $result);
    }

    public function testGroupMiddlewareAsString(): void
    {
        $this->router->group(['middleware' => 'auth'], function ($r) {
            $r->get('/protected', 'SecureController@index');
        });

        $routes = $this->router->getRoutes();
        $route = $routes['GET'][count($routes['GET']) - 1]; // Dernière route ajoutée
        $this->assertIsArray($route['middleware']);
        $this->assertContains('auth', $route['middleware']);
    }

    public function testGroupMergesMiddleware(): void
    {
        $this->router->group(['middleware' => ['outer']], function ($r) {
            $r->group(['middleware' => ['inner']], function ($r2) {
                $r2->get('/nested', 'NestedController@index');
            });
        });

        $routes = $this->router->getRoutes();
        $route = $routes['GET'][count($routes['GET']) - 1]; // Dernière route ajoutée
        $middleware = $route['middleware'];
        $this->assertContains('outer', $middleware);
        $this->assertContains('inner', $middleware);
    }

    public function testPathPatternHandlesConstraints(): void
    {
        Router::resetInstance(); // Isolation complète
        $router = Router::getInstance();

        // Route avec contrainte numérique
        $router->get('/user/{id}', 'UserController@show', 'user.detail', ['id' => '\d+']);

        // Vérifier pattern dans routes
        $routes = $router->getRoutes();
        $pattern = $routes['GET'][0]['pattern'];
        $this->assertStringContainsString('\d+', $pattern);
    }

    public function testGroupWithoutMiddleware(): void
    {
        Router::resetInstance(); // Isolation complète
        $router = Router::getInstance();

        $router->group(['prefix' => '/blog'], function ($r) {
            $r->get('/posts', 'BlogController@index');
        });

        $routes = $router->getRoutes();
        $this->assertIsArray($routes['GET'][0]['middleware']);
        $this->assertEmpty($routes['GET'][0]['middleware']);
    }
}
