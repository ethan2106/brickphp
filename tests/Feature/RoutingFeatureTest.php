<?php

declare(strict_types=1);

namespace Tests\Feature;

use BrickPHP\Core\Application;
use BrickPHP\Http\Request;
use BrickPHP\Routing\Router;
use PHPUnit\Framework\TestCase;

class RoutingFeatureTest extends TestCase
{
    private Application $app;
    
    protected function setUp(): void
    {
        $this->app = Application::getInstance();
    }
    
    public function testBasicRouting(): void
    {
        $router = $this->app->getRouter();
        $router->get('/test', fn() => 'Test Response');
        
        $match = $router->match('GET', '/test');
        
        $this->assertNotNull($match);
    }
    
    public function testParameterizedRoute(): void
    {
        $router = $this->app->getRouter();
        $router->get('/user/{id}', fn($request, $id) => "User {$id}");
        
        $match = $router->match('GET', '/user/42');
        
        $this->assertNotNull($match);
        $this->assertEquals('42', $match['params']['id']);
    }
    
    public function testRESTfulResourceRoutes(): void
    {
        $router = new Router();
        $router->resource('posts', 'PostController');
        
        // Test index route
        $match = $router->match('GET', '/posts');
        $this->assertNotNull($match);
        $this->assertEquals('index', $match['action']);
        
        // Test show route
        $match = $router->match('GET', '/posts/1');
        $this->assertNotNull($match);
        $this->assertEquals('show', $match['action']);
        
        // Test store route
        $match = $router->match('POST', '/posts');
        $this->assertNotNull($match);
        $this->assertEquals('store', $match['action']);
        
        // Test update route
        $match = $router->match('PUT', '/posts/1');
        $this->assertNotNull($match);
        $this->assertEquals('update', $match['action']);
        
        // Test destroy route
        $match = $router->match('DELETE', '/posts/1');
        $this->assertNotNull($match);
        $this->assertEquals('destroy', $match['action']);
    }
}
