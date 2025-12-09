<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Database;
use App\Model\UserModel;
use PHPUnit\Framework\TestCase;

/**
 * Test complet du flow : Registration → Login → Protected Access
 */
class FullFlowTest extends TestCase
{
    private Database $db;
    private UserModel $userModel;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup SQLite in-memory
        if (!defined('DB_DRIVER')) {
            define('DB_DRIVER', 'sqlite');
        }
        if (!defined('DB_NAME')) {
            define('DB_NAME', ':memory:');
        }

        Database::resetInstance();
        $this->db = Database::getInstance();
        $this->userModel = new UserModel($this->db);

        $this->createUsersTable();

        // Init session
        if (session_status() === \PHP_SESSION_NONE) {
            @session_start();
        }
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        Database::resetInstance();
        parent::tearDown();
    }

    private function createUsersTable(): void
    {
        $sql = 'CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )';
        $this->db->query($sql);
    }

    public function testCompleteUserJourney(): void
    {
        $email = 'journey@example.com';
        $password = 'securePass123';
        $name = 'Journey User';

        // ÉTAPE 1: Registration
        $userId = $this->userModel->register($email, $password, $name);
        $this->assertIsInt($userId);
        $this->assertGreaterThan(0, $userId);

        // ÉTAPE 2: Vérifier que user existe en DB
        $registeredUser = $this->userModel->findByEmail($email);
        $this->assertNotNull($registeredUser);
        $this->assertEquals($email, $registeredUser['email']);
        $this->assertEquals($name, $registeredUser['name']);

        // ÉTAPE 3: Login (authentication)
        $authenticatedUser = $this->userModel->authenticate($email, $password);
        $this->assertNotNull($authenticatedUser);
        $this->assertEquals($email, $authenticatedUser['email']);
        $this->assertArrayNotHasKey('password', $authenticatedUser);

        // ÉTAPE 4: Simuler mise en session
        $_SESSION['user'] = $authenticatedUser;
        $this->assertTrue(isset($_SESSION['user']));
        $this->assertEquals($email, $_SESSION['user']['email']);

        // ÉTAPE 5: Vérifier accès protected (simuler middleware auth)
        $isAuthenticated = isset($_SESSION['user']) && is_array($_SESSION['user']);
        $this->assertTrue($isAuthenticated);

        // ÉTAPE 6: Logout
        unset($_SESSION['user']);
        $this->assertFalse(isset($_SESSION['user']));

        // ÉTAPE 7: Re-login avec mauvais mot de passe
        $failedAuth = $this->userModel->authenticate($email, 'wrongPassword');
        $this->assertNull($failedAuth);

        // ÉTAPE 8: Re-login avec bon mot de passe
        $reAuthUser = $this->userModel->authenticate($email, $password);
        $this->assertNotNull($reAuthUser);
        $this->assertEquals($email, $reAuthUser['email']);
    }

    public function testMultipleUsersIsolation(): void
    {
        $users = [
            ['email' => 'alice@test.com', 'password' => 'alicePass', 'name' => 'Alice'],
            ['email' => 'bob@test.com', 'password' => 'bobPass', 'name' => 'Bob'],
            ['email' => 'charlie@test.com', 'password' => 'charliePass', 'name' => 'Charlie'],
        ];

        // Register tous les users
        $userIds = [];
        foreach ($users as $userData) {
            $id = $this->userModel->register(
                $userData['email'],
                $userData['password'],
                $userData['name']
            );
            $userIds[] = $id;
        }

        // Vérifier isolation : chaque user a son propre ID
        $this->assertCount(3, array_unique($userIds));

        // Vérifier que Alice ne peut pas s'authentifier avec le password de Bob
        $aliceWithBobPassword = $this->userModel->authenticate('alice@test.com', 'bobPass');
        $this->assertNull($aliceWithBobPassword);

        // Vérifier authentification correcte pour chaque user
        foreach ($users as $userData) {
            $user = $this->userModel->authenticate($userData['email'], $userData['password']);
            $this->assertNotNull($user);
            $this->assertEquals($userData['email'], $user['email']);
        }
    }

    public function testSessionPersistenceAcrossRequests(): void
    {
        $email = 'session@test.com';
        $password = 'sessionPass';
        $name = 'Session User';

        // Enregistrement
        $this->userModel->register($email, $password, $name);

        // Login
        $user = $this->userModel->authenticate($email, $password);
        $_SESSION['user'] = $user;

        // Simuler une nouvelle requête (session persiste)
        $storedUser = $_SESSION['user'] ?? null;
        $this->assertNotNull($storedUser);
        $this->assertEquals($email, $storedUser['email']);

        // Modifier session
        $_SESSION['user']['custom_field'] = 'custom_value';
        $this->assertEquals('custom_value', $_SESSION['user']['custom_field']);
    }

    public function testPasswordChangeScenario(): void
    {
        $email = 'changepass@test.com';
        $oldPassword = 'oldPassword123';
        $newPassword = 'newPassword456';
        $name = 'Password Changer';

        // Enregistrement initial
        $this->userModel->register($email, $oldPassword, $name);

        // Authentification avec ancien mot de passe
        $user = $this->userModel->authenticate($email, $oldPassword);
        $this->assertNotNull($user);

        // Simuler changement de mot de passe (update en DB)
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = 'UPDATE users SET password = :password WHERE email = :email';
        $this->db->query($sql, ['password' => $hashedNewPassword, 'email' => $email]);

        // Ancien mot de passe ne fonctionne plus
        $oldAuth = $this->userModel->authenticate($email, $oldPassword);
        $this->assertNull($oldAuth);

        // Nouveau mot de passe fonctionne
        $newAuth = $this->userModel->authenticate($email, $newPassword);
        $this->assertNotNull($newAuth);
        $this->assertEquals($email, $newAuth['email']);
    }

    public function testConcurrentLoginAttempts(): void
    {
        $email = 'concurrent@test.com';
        $password = 'concurrentPass';
        $name = 'Concurrent User';

        $this->userModel->register($email, $password, $name);

        // Simuler plusieurs tentatives simultanées
        $results = [];
        for ($i = 0; $i < 5; $i++) {
            $user = $this->userModel->authenticate($email, $password);
            $results[] = $user !== null;
        }

        // Toutes les tentatives devraient réussir
        $this->assertEquals([true, true, true, true, true], $results);
    }

    public function testAccountDeletion(): void
    {
        $email = 'delete@test.com';
        $password = 'deletePass';
        $name = 'Delete User';

        $this->userModel->register($email, $password, $name);

        // Vérifier existence
        $user = $this->userModel->findByEmail($email);
        $this->assertNotNull($user);

        // Supprimer compte
        $sql = 'DELETE FROM users WHERE email = :email';
        $this->db->query($sql, ['email' => $email]);

        // Vérifier suppression
        $deletedUser = $this->userModel->findByEmail($email);
        $this->assertNull($deletedUser);

        // Login ne devrait plus fonctionner
        $authAttempt = $this->userModel->authenticate($email, $password);
        $this->assertNull($authAttempt);
    }
}
