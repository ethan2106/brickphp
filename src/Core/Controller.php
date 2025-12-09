<?php

declare(strict_types=1);

namespace BrickPHP\Core;

use BrickPHP\Http\Request;
use BrickPHP\Http\Response;
use BrickPHP\View\ViewEngine;

/**
 * Base Controller Class
 * 
 * All application controllers should extend this class.
 */
abstract class Controller
{
    protected ViewEngine $view;
    
    public function __construct()
    {
        $app = Application::getInstance();
        $this->view = $app->getContainer()->make(ViewEngine::class);
    }
    
    /**
     * Render view template
     */
    protected function render(string $template, array $data = []): Response
    {
        $content = $this->view->render($template, $data);
        return Response::html($content);
    }
    
    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): Response
    {
        return Response::json($data, $statusCode);
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect(string $url, int $statusCode = 302): Response
    {
        return Response::redirect($url, $statusCode);
    }
    
    /**
     * Validate request data
     */
    protected function validate(Request $request, array $rules): array
    {
        $validator = new \BrickPHP\Security\Validator($request->all(), $rules);
        
        if ($validator->fails()) {
            throw new \RuntimeException(
                'Validation failed: ' . json_encode($validator->getErrors())
            );
        }
        
        return $request->all();
    }
}
