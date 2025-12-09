<?php

declare(strict_types=1);

namespace BrickPHP\Core;

use Closure;
use ReflectionClass;
use ReflectionParameter;

/**
 * Dependency Injection Container
 * 
 * Manages service resolution and dependency injection.
 */
class Container
{
    private array $bindings = [];
    private array $singletons = [];
    private array $instances = [];
    
    /**
     * Bind a service to the container
     */
    public function bind(string $abstract, Closure|string|null $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'singleton' => false,
        ];
    }
    
    /**
     * Bind a singleton service to the container
     */
    public function singleton(string $abstract, Closure|string|null $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'singleton' => true,
        ];
    }
    
    /**
     * Register an existing instance as singleton
     */
    public function instance(string $abstract, object $instance): void
    {
        $this->instances[$abstract] = $instance;
    }
    
    /**
     * Resolve a service from the container
     */
    public function make(string $abstract, array $parameters = []): mixed
    {
        // Check if instance already exists
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        
        // Get concrete implementation
        $concrete = $this->getConcrete($abstract);
        
        // Build instance
        $object = $this->build($concrete, $parameters);
        
        // Store singleton instance
        if (isset($this->bindings[$abstract]) && $this->bindings[$abstract]['singleton']) {
            $this->instances[$abstract] = $object;
        }
        
        return $object;
    }
    
    /**
     * Get concrete implementation
     */
    private function getConcrete(string $abstract): Closure|string
    {
        if (!isset($this->bindings[$abstract])) {
            return $abstract;
        }
        
        return $this->bindings[$abstract]['concrete'];
    }
    
    /**
     * Build an instance of the concrete implementation
     */
    private function build(Closure|string $concrete, array $parameters = []): mixed
    {
        // If closure, execute it
        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }
        
        // Reflection to resolve dependencies
        $reflector = new ReflectionClass($concrete);
        
        if (!$reflector->isInstantiable()) {
            throw new \RuntimeException("Class {$concrete} is not instantiable.");
        }
        
        $constructor = $reflector->getConstructor();
        
        if ($constructor === null) {
            return new $concrete();
        }
        
        $dependencies = $this->resolveDependencies($constructor->getParameters(), $parameters);
        
        return $reflector->newInstanceArgs($dependencies);
    }
    
    /**
     * Resolve constructor dependencies
     */
    private function resolveDependencies(array $parameters, array $primitives = []): array
    {
        $dependencies = [];
        
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            
            // Check if primitive value provided
            if (isset($primitives[$name])) {
                $dependencies[] = $primitives[$name];
                continue;
            }
            
            // Get type hint
            $type = $parameter->getType();
            
            if ($type === null) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \RuntimeException("Cannot resolve parameter {$name}");
                }
                continue;
            }
            
            // For named types (classes)
            if (!$type->isBuiltin()) {
                $className = $type->getName();
                $dependencies[] = $this->make($className);
                continue;
            }
            
            // For built-in types with defaults
            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new \RuntimeException("Cannot resolve parameter {$name}");
            }
        }
        
        return $dependencies;
    }
    
    /**
     * Check if service is bound
     */
    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }
}
