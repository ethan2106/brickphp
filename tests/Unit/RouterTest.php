<?php

declare(strict_types=1);

namespace Tests\Unit;

use BrickPHP\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;
    
    protected function setUp(): void
    {
        $this->router = new Router();
    }
    
    public function testGetRoute(): void
    {
        $this->router->get('/test', ['TestController', 'index']);
        $match = $this->router->match('GET', '/test');
        
        $this->assertNotNull($match);
        $this->assertEquals('TestController', $match['controller']);
        $this->assertEquals('index', $match['action']);
    }
    
    public function testPostRoute(): void
    {
        $this->router->post('/submit', ['FormController', 'submit']);
        $match = $this->router->match('POST', '/submit');
        
        $this->assertNotNull($match);
        $this->assertEquals('FormController', $match['controller']);
    }
    
    public function testPutRoute(): void
    {
        $this->router->put('/update', ['UpdateController', 'update']);
        $match = $this->router->match('PUT', '/update');
        
        $this->assertNotNull($match);
    }
    
    public function testDeleteRoute(): void
    {
        $this->router->delete('/delete', ['DeleteController', 'delete']);
        $match = $this->router->match('DELETE', '/delete');
        
        $this->assertNotNull($match);
    }
    
    public function testPatchRoute(): void
    {
        $this->router->patch('/patch', ['PatchController', 'patch']);
        $match = $this->router->match('PATCH', '/patch');
        
        $this->assertNotNull($match);
    }
    
    public function testRouteWithParameters(): void
    {
        $this->router->get('/user/{id}', ['UserController', 'show']);
        $match = $this->router->match('GET', '/user/123');
        
        $this->assertNotNull($match);
        $this->assertArrayHasKey('id', $match['params']);
        $this->assertEquals('123', $match['params']['id']);
    }
    
    public function testRouteWithMultipleParameters(): void
    {
        $this->router->get('/post/{id}/comment/{commentId}', ['CommentController', 'show']);
        $match = $this->router->match('GET', '/post/42/comment/7');
        
        $this->assertNotNull($match);
        $this->assertEquals('42', $match['params']['id']);
        $this->assertEquals('7', $match['params']['commentId']);
    }
    
    public function testRouteNotFound(): void
    {
        $this->router->get('/test', ['TestController', 'index']);
        $match = $this->router->match('GET', '/nonexistent');
        
        $this->assertNull($match);
    }
    
    public function testMethodNotMatching(): void
    {
        $this->router->get('/test', ['TestController', 'index']);
        $match = $this->router->match('POST', '/test');
        
        $this->assertNull($match);
    }
    
    public function testNamedRoute(): void
    {
        $this->router->get('/profile/{id}', ['ProfileController', 'show'], 'profile.show');
        $url = $this->router->url('profile.show', ['id' => '123']);
        
        $this->assertEquals('/profile/123', $url);
    }
    
    public function testMiddleware(): void
    {
        $this->router->get('/admin', ['AdminController', 'index'])
            ->middleware('auth');
        
        $match = $this->router->match('GET', '/admin');
        
        $this->assertContains('auth', $match['middleware']);
    }
    
    public function testMultipleMiddleware(): void
    {
        $this->router->get('/admin', ['AdminController', 'index'])
            ->middleware(['auth', 'admin']);
        
        $match = $this->router->match('GET', '/admin');
        
        $this->assertCount(2, $match['middleware']);
        $this->assertContains('auth', $match['middleware']);
        $this->assertContains('admin', $match['middleware']);
    }
    
    public function testResourceRoutes(): void
    {
        $this->router->resource('users', 'UserController');
        
        $routes = [
            ['GET', '/users', 'index'],
            ['GET', '/users/create', 'create'],
            ['POST', '/users', 'store'],
            ['GET', '/users/123', 'show'],
            ['GET', '/users/123/edit', 'edit'],
            ['PUT', '/users/123', 'update'],
            ['DELETE', '/users/123', 'destroy'],
        ];
        
        foreach ($routes as [$method, $path, $action]) {
            $match = $this->router->match($method, $path);
            $this->assertNotNull($match, "Route {$method} {$path} not found");
            $this->assertEquals($action, $match['action']);
        }
    }
    
    public function testAnyMethod(): void
    {
        $this->router->any('/any', ['AnyController', 'handle']);
        
        $methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
        foreach ($methods as $method) {
            $match = $this->router->match($method, '/any');
            $this->assertNotNull($match, "Method {$method} not matched");
        }
    }
}
