<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        Router::resetInstance();
    }

    protected function tearDown(): void
    {
        Router::resetInstance();
    }

    public function testGetInstanceReturnsSingleton(): void
    {
        $router1 = Router::getInstance();
        $router2 = Router::getInstance();

        $this->assertSame($router1, $router2);
        $this->assertInstanceOf(Router::class, $router1);
    }

    public function testAddRouteAndGenerateUrl(): void
    {
        $router = Router::getInstance();

        $router->get('/users/{id}', 'UserController@show', 'user.show');

        $url = $router->url('user.show', ['id' => 123]);

        $this->assertEquals('/users/123', $url);
    }

    public function testUrlWithMissingParameterThrowsException(): void
    {
        $router = Router::getInstance();

        $router->get('/users/{id}', 'UserController@show', 'user.show');

        $this->expectException(\RuntimeException::class);
        $router->url('user.show', []);
    }

    public function testUrlWithUnknownRouteThrowsException(): void
    {
        $router = Router::getInstance();

        $this->expectException(\RuntimeException::class);
        $router->url('unknown.route', []);
    }
}
