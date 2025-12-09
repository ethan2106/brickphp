<?php

declare(strict_types=1);

namespace Tests\Feature;

use BrickPHP\Security\Validator;
use BrickPHP\Http\Request;
use PHPUnit\Framework\TestCase;

class SecurityFeatureTest extends TestCase
{
    public function testXSSProtectionInRequest(): void
    {
        $maliciousInput = '<script>alert("XSS")</script>';
        $request = new Request('POST', '/', [], ['comment' => $maliciousInput]);
        
        $sanitized = $request->post('comment');
        
        $this->assertStringNotContainsString('<script>', $sanitized);
        $this->assertStringContainsString('&lt;script&gt;', $sanitized);
    }
    
    public function testSQLInjectionPrevention(): void
    {
        // Test that validator doesn't allow SQL injection patterns
        $data = ['username' => "admin' OR '1'='1"];
        $rules = ['username' => 'required|alphanumeric'];
        
        $validator = new Validator($data, $rules);
        
        // Should fail because of special characters
        $this->assertTrue($validator->fails());
    }
    
    public function testDirectoryTraversalPrevention(): void
    {
        $maliciousPath = '/user/../../etc/passwd';
        $request = new Request('GET', $maliciousPath);
        
        // Path should be sanitized
        $this->assertStringNotContainsString('..', $request->getPath());
    }
    
    public function testFormValidation(): void
    {
        $data = [
            'email' => 'test@example.com',
            'password' => 'securepassword123',
            'age' => '25',
        ];
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'age' => 'required|numeric',
        ];
        
        $validator = new Validator($data, $rules);
        
        $this->assertTrue($validator->passes());
    }
    
    public function testFormValidationFailure(): void
    {
        $data = [
            'email' => 'invalid-email',
            'password' => '123',
            'age' => 'not-a-number',
        ];
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'age' => 'required|numeric',
        ];
        
        $validator = new Validator($data, $rules);
        
        $this->assertTrue($validator->fails());
        $errors = $validator->getErrors();
        
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('password', $errors);
        $this->assertArrayHasKey('age', $errors);
    }
    
    public function testInputSanitization(): void
    {
        $dirtyInput = '<p>Hello <script>alert("xss")</script> World</p>';
        
        $sanitized = Validator::sanitize($dirtyInput);
        $cleaned = Validator::clean($dirtyInput);
        
        // Sanitize should escape HTML
        $this->assertStringContainsString('&lt;', $sanitized);
        $this->assertStringNotContainsString('<script>', $sanitized);
        
        // Clean should strip all tags
        $this->assertStringNotContainsString('<', $cleaned);
        $this->assertStringContainsString('Hello', $cleaned);
        $this->assertStringContainsString('World', $cleaned);
    }
}
