<?php

declare(strict_types=1);

namespace Tests\Unit;

use BrickPHP\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testBasicResponse(): void
    {
        $response = new Response('Hello World', 200);
        
        $this->assertEquals('Hello World', $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    public function testSecurityHeaders(): void
    {
        $response = new Response();
        
        $this->assertEquals('nosniff', $response->getHeader('X-Content-Type-Options'));
        $this->assertEquals('DENY', $response->getHeader('X-Frame-Options'));
        $this->assertEquals('1; mode=block', $response->getHeader('X-XSS-Protection'));
    }
    
    public function testSetContent(): void
    {
        $response = new Response();
        $response->setContent('New Content');
        
        $this->assertEquals('New Content', $response->getContent());
    }
    
    public function testSetStatusCode(): void
    {
        $response = new Response();
        $response->setStatusCode(404);
        
        $this->assertEquals(404, $response->getStatusCode());
    }
    
    public function testSetHeader(): void
    {
        $response = new Response();
        $response->setHeader('Custom-Header', 'value');
        
        $this->assertEquals('value', $response->getHeader('Custom-Header'));
    }
    
    public function testJsonResponse(): void
    {
        $data = ['key' => 'value', 'number' => 123];
        $response = Response::json($data);
        
        $this->assertEquals(json_encode($data), $response->getContent());
        $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    }
    
    public function testJsonResponseWithStatus(): void
    {
        $response = Response::json(['error' => 'Not Found'], 404);
        
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('Not Found', $response->getContent());
    }
    
    public function testRedirectResponse(): void
    {
        $response = Response::redirect('/new-location');
        
        $this->assertEquals('/new-location', $response->getHeader('Location'));
        $this->assertEquals(302, $response->getStatusCode());
    }
    
    public function testRedirectWithCustomStatus(): void
    {
        $response = Response::redirect('/permanent', 301);
        
        $this->assertEquals(301, $response->getStatusCode());
    }
    
    public function testHtmlResponse(): void
    {
        $html = '<h1>Hello</h1>';
        $response = Response::html($html);
        
        $this->assertEquals($html, $response->getContent());
        $this->assertEquals('text/html; charset=UTF-8', $response->getHeader('Content-Type'));
    }
    
    public function testGetAllHeaders(): void
    {
        $response = new Response();
        $headers = $response->getHeaders();
        
        $this->assertIsArray($headers);
        $this->assertArrayHasKey('X-Content-Type-Options', $headers);
        $this->assertArrayHasKey('X-Frame-Options', $headers);
    }
}
