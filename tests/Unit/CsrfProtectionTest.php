<?php

declare(strict_types=1);

namespace Tests\Unit;

use BrickPHP\Security\CsrfProtection;
use PHPUnit\Framework\TestCase;

class CsrfProtectionTest extends TestCase
{
    private CsrfProtection $csrf;
    
    protected function setUp(): void
    {
        // Start session for CSRF tests
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->csrf = new CsrfProtection();
    }
    
    protected function tearDown(): void
    {
        // Clean up session
        if (isset($_SESSION['_csrf_token'])) {
            unset($_SESSION['_csrf_token']);
        }
    }
    
    public function testGenerateToken(): void
    {
        $token = $this->csrf->generateToken();
        
        $this->assertIsString($token);
        $this->assertNotEmpty($token);
        $this->assertEquals(64, strlen($token)); // 32 bytes hex = 64 chars
    }
    
    public function testTokenPersistence(): void
    {
        $token1 = $this->csrf->generateToken();
        $token2 = $this->csrf->generateToken();
        
        // Should return same token
        $this->assertEquals($token1, $token2);
    }
    
    public function testGetToken(): void
    {
        $generated = $this->csrf->generateToken();
        $retrieved = $this->csrf->getToken();
        
        $this->assertEquals($generated, $retrieved);
    }
    
    public function testValidateToken(): void
    {
        $token = $this->csrf->generateToken();
        
        $this->assertTrue($this->csrf->validateToken($token));
    }
    
    public function testValidateInvalidToken(): void
    {
        $this->csrf->generateToken();
        
        $this->assertFalse($this->csrf->validateToken('invalid-token'));
    }
    
    public function testFieldMethod(): void
    {
        $field = $this->csrf->field();
        
        $this->assertStringContainsString('<input', $field);
        $this->assertStringContainsString('type="hidden"', $field);
        $this->assertStringContainsString('name="_csrf_token"', $field);
    }
    
    public function testMetaMethod(): void
    {
        $meta = $this->csrf->meta();
        
        $this->assertStringContainsString('<meta', $meta);
        $this->assertStringContainsString('name="csrf-token"', $meta);
        $this->assertStringContainsString('content=', $meta);
    }
}
