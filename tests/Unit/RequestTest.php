<?php

declare(strict_types=1);

namespace Tests\Unit;

use BrickPHP\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testCreateRequestWithBasicParameters(): void
    {
        $request = new Request('GET', '/test', ['key' => 'value']);
        
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('/test', $request->getPath());
        $this->assertEquals('value', $request->query('key'));
    }
    
    public function testPathSanitization(): void
    {
        $request = new Request('GET', '///test//path//');
        $this->assertEquals('/test/path', $request->getPath());
    }
    
    public function testDirectoryTraversalPrevention(): void
    {
        $request = new Request('GET', '/test/../../../etc/passwd');
        $this->assertEquals('/test/etc/passwd', $request->getPath());
    }
    
    public function testXSSProtectionInQuery(): void
    {
        $request = new Request('GET', '/', ['xss' => '<script>alert("xss")</script>']);
        $value = $request->query('xss');
        
        $this->assertStringNotContainsString('<script>', $value);
        $this->assertStringContainsString('&lt;script&gt;', $value);
    }
    
    public function testXSSProtectionInPost(): void
    {
        $request = new Request('POST', '/', [], ['xss' => '<script>alert("xss")</script>']);
        $value = $request->post('xss');
        
        $this->assertStringNotContainsString('<script>', $value);
        $this->assertStringContainsString('&lt;script&gt;', $value);
    }
    
    public function testInputMethod(): void
    {
        $request = new Request('POST', '/', ['q' => 'query'], ['p' => 'post']);
        
        $this->assertEquals('post', $request->input('p'));
        $this->assertEquals('query', $request->input('q'));
    }
    
    public function testAllMethod(): void
    {
        $request = new Request('POST', '/', ['q' => 'query'], ['p' => 'post']);
        $all = $request->all();
        
        $this->assertArrayHasKey('q', $all);
        $this->assertArrayHasKey('p', $all);
    }
    
    public function testIsAjax(): void
    {
        $request = new Request('GET', '/', [], [], [], [
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
        ]);
        
        $this->assertTrue($request->isAjax());
    }
    
    public function testIsJson(): void
    {
        $request = new Request('POST', '/', [], [], [], [
            'HTTP_CONTENT_TYPE' => 'application/json'
        ]);
        
        $this->assertTrue($request->isJson());
    }
    
    public function testJsonDecoding(): void
    {
        $jsonData = '{"name":"test","value":123}';
        $request = new Request('POST', '/', [], [], [], [], $jsonData);
        $decoded = $request->json();
        
        $this->assertIsArray($decoded);
        $this->assertEquals('test', $decoded['name']);
        $this->assertEquals(123, $decoded['value']);
    }
    
    public function testHeaderParsing(): void
    {
        $request = new Request('GET', '/', [], [], [], [
            'HTTP_USER_AGENT' => 'TestAgent',
            'HTTP_ACCEPT' => 'text/html',
            'CONTENT_TYPE' => 'application/json'
        ]);
        
        $this->assertEquals('TestAgent', $request->header('User-Agent'));
        $this->assertEquals('text/html', $request->header('Accept'));
    }
    
    public function testCsrfValidation(): void
    {
        $token = 'test-csrf-token';
        $request = new Request('POST', '/', [], ['_csrf_token' => $token]);
        
        $this->assertTrue($request->validateCsrf($token));
        $this->assertFalse($request->validateCsrf('wrong-token'));
    }
}
