<?php

declare(strict_types=1);

namespace Tests\Unit;

use BrickPHP\Security\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testRequiredValidation(): void
    {
        $data = ['name' => 'John'];
        $rules = ['name' => 'required'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testRequiredValidationFails(): void
    {
        $data = ['name' => ''];
        $rules = ['name' => 'required'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->fails());
    }
    
    public function testEmailValidation(): void
    {
        $data = ['email' => 'test@example.com'];
        $rules = ['email' => 'email'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testEmailValidationFails(): void
    {
        $data = ['email' => 'invalid-email'];
        $rules = ['email' => 'email'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->fails());
    }
    
    public function testNumericValidation(): void
    {
        $data = ['age' => '25'];
        $rules = ['age' => 'numeric'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testNumericValidationFails(): void
    {
        $data = ['age' => 'not-a-number'];
        $rules = ['age' => 'numeric'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->fails());
    }
    
    public function testMinLengthValidation(): void
    {
        $data = ['password' => 'password123'];
        $rules = ['password' => 'min:8'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testMinLengthValidationFails(): void
    {
        $data = ['password' => '123'];
        $rules = ['password' => 'min:8'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->fails());
    }
    
    public function testMaxLengthValidation(): void
    {
        $data = ['username' => 'john'];
        $rules = ['username' => 'max:20'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testMaxLengthValidationFails(): void
    {
        $data = ['username' => str_repeat('a', 50)];
        $rules = ['username' => 'max:20'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->fails());
    }
    
    public function testMultipleRules(): void
    {
        $data = ['email' => 'test@example.com'];
        $rules = ['email' => 'required|email'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testAlphaValidation(): void
    {
        $data = ['name' => 'John'];
        $rules = ['name' => 'alpha'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testAlphaValidationFails(): void
    {
        $data = ['name' => 'John123'];
        $rules = ['name' => 'alpha'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->fails());
    }
    
    public function testAlphanumericValidation(): void
    {
        $data = ['username' => 'John123'];
        $rules = ['username' => 'alphanumeric'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testUrlValidation(): void
    {
        $data = ['website' => 'https://example.com'];
        $rules = ['website' => 'url'];
        
        $validator = new Validator($data, $rules);
        $this->assertTrue($validator->passes());
    }
    
    public function testGetErrors(): void
    {
        $data = ['name' => ''];
        $rules = ['name' => 'required'];
        
        $validator = new Validator($data, $rules);
        $validator->validate();
        $errors = $validator->getErrors();
        
        $this->assertIsArray($errors);
        $this->assertArrayHasKey('name', $errors);
    }
    
    public function testSanitizeMethod(): void
    {
        $input = '<script>alert("xss")</script>';
        $sanitized = Validator::sanitize($input);
        
        $this->assertStringNotContainsString('<script>', $sanitized);
        $this->assertStringContainsString('&lt;script&gt;', $sanitized);
    }
    
    public function testCleanMethod(): void
    {
        $input = '<p>Hello <b>World</b></p>';
        $cleaned = Validator::clean($input);
        
        $this->assertEquals('Hello World', $cleaned);
    }
}
