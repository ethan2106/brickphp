<?php

/**
 * Contrôleur de base
 * Fournit des méthodes communes : authentification, CSRF, réponses JSON, rendu de vues.
 *
 * CORRECTIONS APPLIQUÉES (v1.1):
 * - getJsonBody() pour lire le body JSON des requêtes AJAX
 * - input() lit automatiquement le JSON body si Content-Type = application/json
 * - validateCsrf() supporte le header X-CSRF-Token pour AJAX
 * - isAjaxRequest() amélioré pour détecter Content-Type et Accept
 */

declare(strict_types=1);

namespace App\Controller;

abstract class BaseController
{
    /** @var array|null Body JSON décodé (cache) */
    protected ?array $jsonBody = null;
    // ===============================
    // Authentification
    // ===============================

    /**
     * Récupère l'ID de l'utilisateur connecté
     */
    protected function getUserId(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    /**
     * Récupère les données de l'utilisateur connecté
     */
    protected function getUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Vérifie si l'utilisateur est connecté
     */
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Exige une authentification (redirige sinon)
     */
    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->redirectToRoute('login');
        }
    }

    /**
     * Exige une authentification pour AJAX (retourne JSON 401 sinon)
     */
    protected function requireAuthJson(): int
    {
        $userId = $this->getUserId();
        if ($userId === null) {
            $this->jsonError('Non authentifié', 401);
        }

        return $userId;
    }

    // ===============================
    // Protection CSRF
    // ===============================

    /**
     * Vérifie le token CSRF
     * Supporte: POST/GET params, header X-CSRF-Token (AJAX)
     */
    protected function validateCsrf(?string $token = null): bool
    {
        // FIX: Supporter aussi le header X-CSRF-Token pour les requêtes AJAX
        $token = $token ?? $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';

        if ($token === '' || $sessionToken === '') {
            return false;
        }

return hash_equals($sessionToken, $token);
    }

    /**
     * Exige un token CSRF valide (JSON 403 sinon)
     */
    protected function requireCsrfJson(): void
    {
        if (!$this->validateCsrf()) {
            $this->jsonError('Token CSRF invalide', 403);
        }
    }

    /**
     * Exige un token CSRF valide (redirige sinon)
     */
    protected function requireCsrf(string $redirectRoute = 'home'): void
    {
        if (!$this->validateCsrf()) {
            $this->flash('error', 'Token de sécurité invalide.');
            $this->redirectToRoute($redirectRoute);
        }
    }

    /**
     * Exige authentification + CSRF pour AJAX
     */
    protected function requireAuthAndCsrfJson(): int
    {
        $userId = $this->requireAuthJson();
        $this->requireCsrfJson();

        return $userId;
    }

    // ===============================
    // Détection requêtes
    // ===============================

    /**
     * Vérifie si c'est une requête AJAX/JSON
     * Détecte: X-Requested-With, Content-Type, Accept
     */
    protected function isAjaxRequest(): bool
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $xRequestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';

        return str_contains($contentType, 'application/json')
            || str_contains($accept, 'application/json')
            || strtolower($xRequestedWith) === 'xmlhttprequest';
    }

    /**
     * Vérifie si c'est une requête POST
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Vérifie si c'est une requête GET
     */
    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    // ===============================
    // Lecture des données d'entrée
    // ===============================

    /**
     * Récupère le body JSON de la requête (avec cache)
     * FIX: Nécessaire car $_POST est vide pour les requêtes JSON
     */
    protected function getJsonBody(): array
    {
        if ($this->jsonBody === null) {
            $rawBody = file_get_contents('php://input');
            if ($rawBody !== false) {
                $decoded = json_decode($rawBody, true);
                $this->jsonBody = is_array($decoded) ? $decoded : [];
            } else {
                $this->jsonBody = [];
            }
        }

        return $this->jsonBody;
    }

    /**
     * Récupère une valeur d'entrée (POST, GET, ou JSON body)
     * FIX: Lit automatiquement le JSON body si Content-Type = application/json
     */
    protected function input(string $key, mixed $default = null): mixed
    {
        // 1. Vérifier d'abord $_POST
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }

        // 2. Vérifier le body JSON (pour requêtes AJAX)
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $jsonBody = $this->getJsonBody();
            if (isset($jsonBody[$key])) {
                return $jsonBody[$key];
            }
        }

        // 3. Vérifier $_GET
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }

        return $default;
    }

    /**
     * Récupère toutes les données d'entrée
     */
    protected function all(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            return array_merge($_GET, $this->getJsonBody());
        }

        return array_merge($_GET, $_POST);
    }

    // ===============================
    // Rendu de vues
    // ===============================

    /**
     * Rend une vue avec le layout
     * Support Twig si disponible, sinon PHP classique
     */
    protected function render(string $view, array $data = [], ?bool $useTwig = null): void
    {
        // Déterminer automatiquement si utiliser Twig
        $useTwig = $useTwig ?? (\App\Service\ViewService::hasTwig() && file_exists(__DIR__ . "/../View/{$view}.twig"));

        if ($useTwig) {
            // Utiliser Twig
            $viewService = \App\Service\ViewService::getInstance();
            $content = $viewService->render($view, $data);

            // Injecter dans le layout PHP (pour l'instant)
            $layoutData = array_merge($data, ['content' => $content]);
            $viewService->renderPhp('layout', $layoutData);
        } else {
            // PHP classique
            extract($data);
            $viewPath = __DIR__ . "/../View/{$view}.php";

            if (!file_exists($viewPath)) {
                throw new \RuntimeException("Vue non trouvée : {$view}");
            }

            ob_start();
            require $viewPath;
            $content = ob_get_clean();

            require __DIR__ . '/../View/layout.php';
        }
    }

    /**
     * Rend une vue sans layout (pour les composants)
     */
    protected function renderPartial(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . "/../View/{$view}.php";
    }

    /**
     * Répond en JSON (pour API)
     */
    protected function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Réponse JSON de succès
     */
    protected function jsonSuccess(array $data = [], string $message = ''): never
    {
        $response = ['success' => true];
        if ($message !== '') {
            $response['message'] = $message;
        }
        $this->json(array_merge($response, $data));
    }

    /**
     * Réponse JSON d'erreur
     */
    protected function jsonError(string $message, int $status = 400): never
    {
        $this->json(['success' => false, 'error' => $message], $status);
    }

    /**
     * Redirige vers une URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Redirige vers une route nommée
     */
    protected function redirectToRoute(string $routeName, array $params = []): void
    {
        $this->redirect(url($routeName, $params));
    }

    // ===============================
    // Messages Flash
    // ===============================

    /**
     * Définit un message flash
     */
    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    /**
     * Récupère et supprime le message flash
     */
    protected function getFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        return $flash;
    }
}
