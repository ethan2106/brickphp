<?php

/**
 * Router - HTTP Route Management System
 *
 * A powerful and flexible router for PHP 8.1+ applications supporting:
 * - RESTful HTTP methods (GET, POST, PUT, DELETE, PATCH, OPTIONS)
 * - Dynamic route parameters with automatic type conversion
 * - Named routes for URL generation
 * - Route groups with prefixes and middleware
 * - Built-in security middleware (auth, guest, csrf)
 * - AJAX support with JSON responses
 * - Method override for HTML forms
 *
 * Built-in Middleware:
 * ┌─────────┬─────────────────────────────────────┬─────────────────────────────┐
 * │ Name    │ Purpose                            │ Response for AJAX           │
 * ├─────────┼─────────────────────────────────────┼─────────────────────────────┤
 * │ 'auth'  │ Requires authentication            │ 401 JSON + redirect        │
 * │ 'guest' │ Requires non-authenticated user    │ 403 JSON + redirect        │
 * │ 'csrf'  │ CSRF protection (POST/PUT/DELETE)  │ 403 JSON + error message   │
 * └─────────┴─────────────────────────────────────┴─────────────────────────────┘
 *
 * Parameter Types: Numeric parameters are automatically converted to integers.
 * Example: /users/{id} with id="123" → controller receives int $id = 123
 *
 * AJAX Support: JSON responses include proper HTTP status codes (401, 403, etc.)
 *
 * Features:
 * - Singleton pattern for global access
 * - Regex-based route matching with parameter extraction
 * - Middleware system supporting both strings and callables
 * - CSRF protection for state-changing operations
 * - Automatic numeric parameter conversion
 * - Optional trailing slashes in URLs
 *
 * @example
 * ```php
 * $router = Router::getInstance();
 *
 * // Basic routes
 * $router->get('/', [HomeController::class, 'index'], 'home');
 * $router->post('/users', [UserController::class, 'store']);
 *
 * // Dynamic parameters
 * $router->get('/users/{id}', [UserController::class, 'show']);
 * $router->put('/users/{id}', [UserController::class, 'update']);
 * $router->delete('/users/{id}', [UserController::class, 'destroy']);
 *
 * // Route groups (concise syntax)
 * $router->group(['middleware' => ['auth']], fn($r) => [
 *     $r->get('/dashboard', [DashboardController::class, 'index']),
 *     $r->get('/profile', [ProfileController::class, 'show']),
 * ]);
 *
 * // Traditional syntax
 * $router->group(['prefix' => '/admin', 'middleware' => ['auth']], function($router) {
 *     $router->get('/dashboard', [AdminController::class, 'dashboard']);
 * });
 *
 * // Generate URLs
 * $url = $router->url('home'); // '/'
 * $url = $router->url('user.show', ['id' => 123]); // '/users/123'
 *
 * // Dispatch request
 * $result = $router->dispatch();
 * ```
 */

declare(strict_types=1);

namespace App\Core;

class Router
{
    private static ?self $instance = null;

    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'PATCH' => [],
        'OPTIONS' => [],
    ];

    private array $namedRoutes = [];

    /** stack of group prefixes */
    private array $groupStack = [];

    /** current middleware stack (strings or callables) */
    private array $middlewareStack = [];

    /** route cache */
    private ?array $routeCache = null;
    private string $cacheFile;
    private bool $cacheEnabled;

    private function __construct()
    {
        $this->cacheFile = __DIR__ . '/../../storage/cache/routes.php';
        $this->cacheEnabled = !APP_DEBUG; // cache only in production
    }

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    // === Route registration ===

    /**
     * Register a GET route with optional constraints
     *
     * @param string $path Route path (e.g., '/users/{id}', '/users/{id}/{slug}')
     * @param array|string $action Controller action ([Controller::class, 'method'] or 'Controller@method')
     * @param string|null $name Optional route name for URL generation
     * @param array $constraints Parameter constraints (e.g., ['id' => '\d+', 'slug' => '[a-z0-9-]+'])
     */
    public function get(string $path, array|string $action, ?string $name = null, array $constraints = []): self
    {
        return $this->addRoute('GET', $path, $action, $name, $constraints);
    }

    /**
     * Register a POST route with optional constraints
     *
     * @param string $path Route path
     * @param array|string $action Controller action
     * @param string|null $name Optional route name for URL generation
     * @param array $constraints Parameter constraints
     */
    public function post(string $path, array|string $action, ?string $name = null, array $constraints = []): self
    {
        return $this->addRoute('POST', $path, $action, $name, $constraints);
    }

    /**
     * Register a PUT route with optional constraints
     *
     * @param string $path Route path
     * @param array|string $action Controller action
     * @param string|null $name Optional route name for URL generation
     * @param array $constraints Parameter constraints
     */
    public function put(string $path, array|string $action, ?string $name = null, array $constraints = []): self
    {
        return $this->addRoute('PUT', $path, $action, $name, $constraints);
    }

    /**
     * Register a DELETE route with optional constraints
     *
     * @param string $path Route path
     * @param array|string $action Controller action
     * @param string|null $name Optional route name for URL generation
     * @param array $constraints Parameter constraints
     */
    public function delete(string $path, array|string $action, ?string $name = null, array $constraints = []): self
    {
        return $this->addRoute('DELETE', $path, $action, $name, $constraints);
    }

    /**
     * Register a PATCH route with optional constraints
     *
     * @param string $path Route path
     * @param array|string $action Controller action
     * @param string|null $name Optional route name for URL generation
     * @param array $constraints Parameter constraints
     */
    public function patch(string $path, array|string $action, ?string $name = null, array $constraints = []): self
    {
        return $this->addRoute('PATCH', $path, $action, $name, $constraints);
    }

    /**
     * Register an OPTIONS route with optional constraints
     *
     * @param string $path Route path
     * @param array|string $action Controller action
     * @param string|null $name Optional route name for URL generation
     * @param array $constraints Parameter constraints
     */
    public function options(string $path, array|string $action, ?string $name = null, array $constraints = []): self
    {
        return $this->addRoute('OPTIONS', $path, $action, $name, $constraints);
    }

    /**
     * Register a route that accepts both GET and POST methods
     *
     * @param string $path Route path
     * @param array|string $action Controller action
     * @param string|null $name Optional route name for URL generation
     * @param array $constraints Parameter constraints
     */
    public function any(string $path, array|string $action, ?string $name = null, array $constraints = []): self
    {
        $this->get($path, $action, $name, $constraints);
        $this->post($path, $action, $name === null ? null : $name . '.post', $constraints);

        return $this;
    }

    /**
     * Group routes with shared configuration
     *
     * @param array $options Group options:
     *   - 'prefix' => string: URL prefix for all routes in group
     *   - 'middleware' => string|array: Middleware(s) applied to all routes in group
     * @param callable $callback Function that receives the router instance
     *
     * @example
     * ```php
     * // Concise syntax (PHP 8.1+)
     * $router->group(['middleware' => ['auth']], fn($r) => [
     *     $r->get('/dashboard', [DashboardController::class, 'index']),
     *     $r->post('/profile', [ProfileController::class, 'update']),
     * ]);
     *
     * // Traditional syntax
     * $router->group(['prefix' => '/api', 'middleware' => ['auth']], function($router) {
     *     $router->get('/users', [UserController::class, 'index']);
     *     $router->post('/users', [UserController::class, 'store']);
     * });
     * ```
     */
    public function group(array $options, callable $callback): self
    {
        $prefix = $options['prefix'] ?? '';
        $middleware = $options['middleware'] ?? [];

        if (!is_array($middleware)) {
            $middleware = [$middleware];
        }

        // push prefix
        $this->groupStack[] = $prefix;

        // backup and extend middleware stack (avoid array_diff issues)
        $previousMiddlewareStack = $this->middlewareStack;
        $this->middlewareStack = array_merge($this->middlewareStack, $middleware);

        // execute callback
        $callback($this);

        // restore stacks
        array_pop($this->groupStack);
        $this->middlewareStack = $previousMiddlewareStack;

        return $this;
    }

    /**
     * Get all registered routes (useful for testing/debugging)
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Get cache file path (for testing)
     *
     * @return string
     */
    public function getCacheFile(): string
    {
        return $this->cacheFile;
    }

    /**
     * Check if cache is enabled (for testing)
     *
     * @return bool
     */
    public function isCacheEnabled(): bool
    {
        return $this->cacheEnabled;
    }

    // === Caching ===

    /**
     * Load routes from cache if available and valid
     */
    private function loadCache(): void
    {
        if (!$this->cacheEnabled || !file_exists($this->cacheFile)) {
            return;
        }

        $cache = include $this->cacheFile;
        if (is_array($cache) && isset($cache['routes'], $cache['named'])) {
            $this->routes = $cache['routes'];
            $this->namedRoutes = $cache['named'];
            $this->routeCache = $cache;
        }
    }

    /**
     * Save current routes to cache
     */
    public function saveCache(): void
    {
        if (!$this->cacheEnabled) {
            return;
        }

        $cacheDir = dirname($this->cacheFile);
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        $cache = [
            'routes' => $this->routes,
            'named' => $this->namedRoutes,
            'timestamp' => time(),
        ];

        $content = '<?php return ' . var_export($cache, true) . ';';
        file_put_contents($this->cacheFile, $content);
    }

    /**
     * Clear route cache
     */
    public function clearCache(): void
    {
        if (file_exists($this->cacheFile)) {
            unlink($this->cacheFile);
        }
        $this->routeCache = null;
    }

    // === Dispatch ===

    /**
     * Dispatch the current HTTP request to the appropriate route
     *
     * This method:
     * - Determines the HTTP method and path from the current request
     * - Supports method override via _method POST parameter or X-HTTP-Method-Override header
     * - Finds the matching route and executes its middleware
     * - Calls the controller action with extracted parameters
     *
     * @return mixed The result of the controller action
     * @throws \RuntimeException If no route matches or controller/method not found
     */
    public function dispatch(): mixed
    {
        // load from cache if not already loaded
        if ($this->routeCache === null) {
            $this->loadCache();
        }

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = $this->getCurrentPath();

        // support method override via _method or header
        if ($method === 'POST') {
            if (isset($_POST['_method'])) {
                $method = strtoupper($_POST['_method']);
            } elseif (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
                $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
            }
        }

        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route) {
            $params = $this->matchRoute($route['pattern'], $path);
            if ($params !== false) {
                // run middlewares (route-level first, then group-level merged on add)
                foreach ($route['middleware'] as $middleware) {
                    $this->runMiddleware($middleware);
                }

                return $this->executeAction($route['action'], $params);
            }
        }

        return $this->handleNotFound();
    }

    /**
     * Generate a URL for a named route
     *
     * @param string $name The route name
     * @param array $params Associative array of route parameters
     * @return string The generated URL
     * @throws \RuntimeException If route name doesn't exist or parameters are missing
     *
     * @example
     * ```php
     * // Route definition: $router->get('/users/{id}', [UserController::class, 'show'], 'user.show');
     * $url = $router->url('user.show', ['id' => 123]); // '/users/123'
     * ```
     */
    public function url(string $name, array $params = []): string
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new \RuntimeException("Route '{$name}' non trouvée.");
        }

        $path = $this->namedRoutes[$name];

        // find placeholders
        preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $path, $matches);
        $placeholders = $matches[1];

        foreach ($placeholders as $ph) {
            if (!array_key_exists($ph, $params)) {
                throw new \RuntimeException("Paramètre '{$ph}' manquant pour la route '{$name}'.");
            }
            $path = str_replace("{{$ph}}", (string) $params[$ph], $path);
        }

        return $path;
    }

    // === Private helpers ===

    private function addRoute(string $method, string $path, array|string $action, ?string $name, array $constraints = []): self
    {
        $fullPath = implode('', $this->groupStack) . $path;
        $fullPath = '/' . ltrim($fullPath, '/');

        $pattern = $this->pathToPattern($fullPath, $constraints);

        $this->routes[$method][] = [
            'path' => $fullPath,
            'pattern' => $pattern,
            'action' => $action,
            // copy current middleware stack for this route (snapshot)
            'middleware' => $this->middlewareStack,
            'name' => $name,
            'constraints' => $constraints, // store for URL generation
        ];

        if ($name !== null && $name !== '') {
            if (isset($this->namedRoutes[$name])) {
                throw new \RuntimeException("Nom de route '{$name}' déjà utilisé.");
            }
            $this->namedRoutes[$name] = $fullPath;
        }

        return $this;
    }

    /**
     * Build a safe regex pattern by quoting static segments and converting {param}
     *
     * Converts paths like '/users/{id}/posts/{slug}' into regex patterns.
     * Supports alphanumeric parameter names with underscores.
     * Allows optional trailing slashes.
     * Supports regex constraints for parameters.
     *
     * Parameter types: Numeric values are automatically converted to integers.
     * Example: /users/{id} with id="123" → controller receives int $id = 123
     *
     * @param string $path The route path
     * @param array $constraints Parameter regex constraints (e.g., ['id' => '\d+', 'slug' => '[a-z0-9-]+'])
     * @return string Regex pattern for matching
     */
    public function pathToPattern(string $path, array $constraints = []): string
    {
        $segments = explode('/', trim($path, '/'));
        $parts = [];

        foreach ($segments as $seg) {
            if ($seg === '') {
                continue;
            }
            $matchResult = preg_match('/^\{([a-zA-Z_][a-zA-Z0-9_]*)\}$/', $seg, $m);
            if ($matchResult !== false && $matchResult > 0) {
                $name = $m[1];
                $regex = $constraints[$name] ?? '[^/]+'; // default: anything except /
                $parts[] = "(?P<{$name}>{$regex})";
            } else {
                $parts[] = preg_quote($seg, '#');
            }
        }

        $regex = '#^/' . implode('/', $parts) . '/?$#'; // allow optional trailing slash

        return $regex;
    }

    public function matchRoute(string $pattern, string $path): array|false
    {
        $matchResult = preg_match($pattern, $path, $matches);
        if ($matchResult !== false && $matchResult > 0) {
            // keep only named captures
            $params = [];
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $params[$key] = is_numeric($value) ? (int) $value : $value;
                }
            }

            return $params;
        }

        return false;
    }

    private function getCurrentPath(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        if ($path === null || $path === false) {
            $path = '/';
        }

        $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
        $scriptDir = str_replace('\\', '/', $scriptDir);

        if ($scriptDir !== '/' && str_starts_with($path, $scriptDir)) {
            $path = substr($path, strlen($scriptDir));
        }

        // decode %20 etc.
        $path = rawurldecode($path);

        return $path === '' ? '/' : $path;
    }

    private function executeAction(array|string $action, array $params): mixed
    {
        if (is_string($action)) {
            [$controllerName, $method] = explode('@', $action);
            $controllerClass = "App\\Controller\\{$controllerName}";
        } else {
            [$controllerClass, $method] = $action;
        }

        if (!class_exists($controllerClass)) {
            throw new \RuntimeException("Controller '{$controllerClass}' non trouvé.");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new \RuntimeException("Méthode '{$method}' non trouvée dans '{$controllerClass}'.");
        }

        // call with named params preserving order
        $callable = [$controller, $method];
        assert(is_callable($callable));

        return $callable(...array_values($params));
    }

    /**
     * Middleware runner: accept string names or callables
     *
     * Built-in string middlewares:
     * - 'auth': Requires user authentication, redirects to /login or returns 401 JSON for AJAX
     * - 'guest': Requires user to be unauthenticated, redirects to / or returns 403 JSON for AJAX
     * - 'csrf': Validates CSRF token for state-changing requests (POST, PUT, DELETE, PATCH)
     *
     * @param string|callable $middleware The middleware to run
     */
    private function runMiddleware(string|callable $middleware): void
    {
        if (is_callable($middleware)) {
            $middleware($this);

            return;
        }

        match ($middleware) {
            'auth' => $this->middlewareAuth(),
            'csrf' => $this->middlewareCsrf(),
            'guest' => $this->middlewareGuest(),
            default => throw new \RuntimeException("Middleware '{$middleware}' inconnu."),
        };
    }

    /**
     * Authentication middleware
     *
     * Checks if user is authenticated by verifying $_SESSION['user'] exists.
     * For AJAX requests, returns JSON 401 response with proper HTTP status code.
     * For regular requests, redirects to /login.
     */
    private function middlewareAuth(): void
    {
        // use centralized helper or config key for session user
        if (!isset($_SESSION['user'])) {
            if ($this->isAjaxRequest()) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Non authentifié']);
                exit;
            }
            header('Location: /login');
            exit;
        }
    }

    /**
     * Guest-only middleware
     *
     * Ensures user is NOT authenticated.
     * For AJAX requests, returns JSON 403 response with proper HTTP status code.
     * For regular requests, redirects to /.
     */
    private function middlewareGuest(): void
    {
        if (isset($_SESSION['user'])) {
            if ($this->isAjaxRequest()) {
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Déjà connecté']);
                exit;
            }
            header('Location: /');
            exit;
        }
    }

    /**
     * CSRF protection middleware
     *
     * Validates CSRF tokens for state-changing HTTP methods (POST, PUT, DELETE, PATCH).
     * Checks both $_POST['csrf_token'] and HTTP_X_CSRF_TOKEN header.
     * Uses hash_equals() for timing attack protection.
     *
     * For AJAX requests, returns JSON 403 response with proper HTTP status code.
     * For regular requests, returns HTTP 403 with error message.
     */
    private function middlewareCsrf(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // check for methods that mutate state
        if (in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'], true)) {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            $sessionToken = $_SESSION['csrf_token'] ?? '';

            if ($token === '' || !hash_equals((string) $sessionToken, (string) $token)) {
                if ($this->isAjaxRequest()) {
                    http_response_code(403);
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'error' => 'Token CSRF invalide']);
                    exit;
                }
                http_response_code(403);
                die('Token CSRF invalide.');
            }
        }
    }

    /**
     * Detect if the current request is an AJAX/JSON request
     *
     * Checks multiple indicators:
     * - Content-Type: application/json
     * - Accept: application/json
     * - X-Requested-With: XMLHttpRequest
     *
     * @return bool True if request appears to be AJAX/JSON
     */
    private function isAjaxRequest(): bool
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $xRequestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';

        return str_contains((string) $contentType, 'application/json')
            || str_contains((string) $accept, 'application/json')
            || strtolower((string) $xRequestedWith) === 'xmlhttprequest';
    }

    private function handleNotFound(): never
    {
        http_response_code(404);
        $view404 = __DIR__ . '/../View/errors/404.php';
        if (file_exists($view404)) {
            require $view404;
        } else {
            echo '<h1>404 - Page non trouvée</h1>';
        }
        exit;
    }

    // testing helper
    public static function resetInstance(): void
    {
        self::$instance = null;
    }
}
