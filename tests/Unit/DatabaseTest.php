<?php

declare(strict_types=1);

namespace Tests\Unit;

use BrickPHP\Database\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabaseConfigurationStorage(): void
    {
        $config = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'test',
            'username' => 'root',
            'password' => 'secret',
        ];
        
        $db = new Database($config);
        
        $this->assertInstanceOf(Database::class, $db);
    }
    
    public function testConnectionThrowsExceptionOnInvalidConfig(): void
    {
        $config = [
            'driver' => 'mysql',
            'host' => 'invalid-host-12345',
            'port' => 3306,
            'database' => 'invalid-db',
            'username' => 'invalid',
            'password' => 'invalid',
        ];
        
        $db = new Database($config);
        
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Database connection failed');
        
        // This should trigger connection and throw exception
        $db->getConnection();
    }
}
