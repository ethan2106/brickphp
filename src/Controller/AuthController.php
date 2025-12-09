<?php

/**
 * Contrôleur Authentification
 */

declare(strict_types=1);

namespace App\Controller;

use App\Model\UserModel;

class AuthController extends BaseController
{
    private ?UserModel $userModel = null;

    public function __construct()
    {
        try {
            $this->userModel = new UserModel();
        } catch (\Exception $e) {
            // DB not available, skip
            $this->userModel = null;
        }
    }

    /**
     * Affiche le formulaire de connexion
     */
    public function loginForm(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirectToRoute('home');
        }

        $this->render('login', [
            'title' => 'Connexion',
        ]);
    }

    /**
     * Traite la connexion
     */
    public function login(): void
    {
        if (!$this->isPost()) {
            $this->redirectToRoute('login');
        }

        // Vérification CSRF
        $this->requireCsrf('login');

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->flash('error', 'Tous les champs sont requis.');
            $this->redirectToRoute('login');
        }

        if ($this->userModel === null) {
            $this->flash('error', 'Base de données non configurée.');
            $this->redirectToRoute('login');
        }

        assert($this->userModel !== null);
        $user = $this->userModel->authenticate($email, $password);

        if ($user !== null) {
            $_SESSION['user'] = $user;
            $this->flash('success', 'Connexion réussie !');
            $this->redirectToRoute('home');
        } else {
            $this->flash('error', 'Email ou mot de passe incorrect.');
            $this->redirectToRoute('login');
        }
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function registerForm(): void
    {
        if ($this->isAuthenticated()) {
            $this->redirectToRoute('home');
        }

        $this->render('register', [
            'title' => 'Inscription',
        ]);
    }

    /**
     * Traite l'inscription
     */
    public function register(): void
    {
        if (!$this->isPost()) {
            $this->redirectToRoute('register');
        }

        // Vérification CSRF
        $this->requireCsrf('register');

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Validations
        if ($name === '' || $email === '' || $password === '') {
            $this->flash('error', 'Tous les champs sont requis.');
            $this->redirectToRoute('register');
        }        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->flash('error', 'Email invalide.');
            $this->redirectToRoute('register');
        }

        if (strlen($password) < 8) {
            $this->flash('error', 'Le mot de passe doit contenir au moins 8 caractères.');
            $this->redirectToRoute('register');
        }

        if ($password !== $passwordConfirm) {
            $this->flash('error', 'Les mots de passe ne correspondent pas.');
            $this->redirectToRoute('register');
        }

        if ($this->userModel === null) {
            $this->flash('error', 'Base de données non configurée.');
            $this->redirectToRoute('register');
        }

        assert($this->userModel !== null);
        if ($this->userModel->findByEmail($email) !== null) {
            $this->flash('error', 'Cet email est déjà utilisé.');
            $this->redirectToRoute('register');
        }

        // Création du compte
        assert($this->userModel !== null);
        $this->userModel->register($email, $password, $name);

        $this->flash('success', 'Compte créé avec succès ! Vous pouvez vous connecter.');
        $this->redirectToRoute('login');
    }

    /**
     * Déconnexion
     */
    public function logout(): void
    {
        // Vérification CSRF pour POST
        if ($this->isPost()) {
            if (!$this->validateCsrf()) {
                $this->redirectToRoute('home');
            }
        }

        session_destroy();
        session_start();

        $this->flash('success', 'Vous êtes déconnecté.');
        $this->redirectToRoute('login');
    }
}
