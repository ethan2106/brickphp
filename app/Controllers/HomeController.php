<?php

declare(strict_types=1);

namespace App\Controllers;

use BrickPHP\Core\Controller;
use BrickPHP\Http\Request;
use BrickPHP\Http\Response;

/**
 * Home Controller
 * 
 * Handles home page requests.
 */
class HomeController extends Controller
{
    /**
     * Display home page
     */
    public function index(Request $request): Response
    {
        return $this->render('home.twig', [
            'title' => 'BrickPHP SUPERCAR',
            'version' => '1.0.0',
            'features' => [
                'MVC Architecture',
                'RESTful Routing',
                'Twig Templates',
                'Alpine.js Integration',
                'Tailwind CSS',
                'CSRF Protection',
                'XSS Protection',
                'SQL Injection Prevention',
                'PDO Database Layer',
                'Dependency Injection',
            ],
        ]);
    }
}
