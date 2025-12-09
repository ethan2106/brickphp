<?php

declare(strict_types=1);

use BrickPHP\Core\Application;

/**
 * Web Routes
 * 
 * Define your application routes here.
 */

$router = Application::getInstance()->getRouter();

// Welcome page
$router->get('/', 'HomeController@index', 'home');

// Example RESTful resource routes
// $router->resource('users', 'UserController');

// Example routes with middleware
// $router->get('/admin', 'AdminController@index')->middleware('auth');
