<?php

declare(strict_types=1);

namespace Tests\Unit;

use BrickPHP\Core\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;
    
    protected function setUp(): void
    {
        $this->container = new Container();
    }
    
    public function testBindAndMake(): void
    {
        $this->container->bind('test', fn() => 'value');
        $result = $this->container->make('test');
        
        $this->assertEquals('value', $result);
    }
    
    public function testSingletonCreatesOneInstance(): void
    {
        $this->container->singleton('test', fn() => new \stdClass());
        
        $instance1 = $this->container->make('test');
        $instance2 = $this->container->make('test');
        
        $this->assertSame($instance1, $instance2);
    }
    
    public function testBindCreatesMultipleInstances(): void
    {
        $this->container->bind('test', fn() => new \stdClass());
        
        $instance1 = $this->container->make('test');
        $instance2 = $this->container->make('test');
        
        $this->assertNotSame($instance1, $instance2);
    }
    
    public function testInstanceRegistration(): void
    {
        $instance = new \stdClass();
        $instance->value = 'test';
        
        $this->container->instance('test', $instance);
        $retrieved = $this->container->make('test');
        
        $this->assertSame($instance, $retrieved);
        $this->assertEquals('test', $retrieved->value);
    }
    
    public function testHasMethod(): void
    {
        $this->assertFalse($this->container->has('test'));
        
        $this->container->bind('test', fn() => 'value');
        $this->assertTrue($this->container->has('test'));
    }
    
    public function testAutowiring(): void
    {
        $instance = $this->container->make(\stdClass::class);
        $this->assertInstanceOf(\stdClass::class, $instance);
    }
}
