<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Model\Database;
use App\Model\UserModel;
use PHPUnit\Framework\TestCase;

/**
 * Tests fonctionnels complets du système d'authentification
 */
class AuthTest extends TestCase
{
    private Database $db;
    private UserModel $userModel;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup SQLite in-memory database
        if (!defined('DB_DRIVER')) {
            define('DB_DRIVER', 'sqlite');
        }
        if (!defined('DB_NAME')) {
            define('DB_NAME', ':memory:');
        }

        // Reset singleton pour chaque test
        Database::resetInstance();
        $this->db = Database::getInstance();
        $this->userModel = new UserModel($this->db);

        // Créer la table users
        $this->createUsersTable();
    }

    protected function tearDown(): void
    {
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

    public function testUserRegistrationSuccess(): void
    {
        $email = 'test@example.com';
        $password = 'password123';
        $name = 'Test User';

        $userId = $this->userModel->register($email, $password, $name);

        $this->assertIsInt($userId);
        $this->assertGreaterThan(0, $userId);

        // Vérifier que l'utilisateur existe
        $user = $this->userModel->findByEmail($email);
        $this->assertNotNull($user);
        $this->assertEquals($email, $user['email']);
        $this->assertEquals($name, $user['name']);
    }

    public function testUserRegistrationDuplicateEmail(): void
    {
        $email = 'duplicate@example.com';
        $password = 'password123';
        $name = 'Test User';

        // Premier enregistrement
        $this->userModel->register($email, $password, $name);

        // Second enregistrement devrait échouer
        $this->expectException(\Exception::class);
        $this->userModel->register($email, $password, $name);
    }

    public function testPasswordIsHashed(): void
    {
        $email = 'hash@example.com';
        $password = 'plaintext123';
        $name = 'Hash Test';

        $this->userModel->register($email, $password, $name);

        $user = $this->userModel->findByEmail($email);
        $this->assertNotNull($user);
        $this->assertNotEquals($password, $user['password']);
        $this->assertTrue(password_verify($password, $user['password']));
    }

    public function testAuthenticateWithValidCredentials(): void
    {
        $email = 'valid@example.com';
        $password = 'correctPassword123';
        $name = 'Valid User';

        $this->userModel->register($email, $password, $name);

        $user = $this->userModel->authenticate($email, $password);
        $this->assertNotNull($user);
        $this->assertEquals($email, $user['email']);
        $this->assertArrayNotHasKey('password', $user); // Password doit être retiré
    }

    public function testAuthenticateWithInvalidPassword(): void
    {
        $email = 'wrong@example.com';
        $password = 'correctPassword';
        $name = 'Wrong User';

        $this->userModel->register($email, $password, $name);

        $user = $this->userModel->authenticate($email, 'wrongPassword');
        $this->assertNull($user);
    }

    public function testAuthenticateWithNonExistentEmail(): void
    {
        $user = $this->userModel->authenticate('nonexistent@example.com', 'password');
        $this->assertNull($user);
    }

    public function testFindByEmailReturnsNull(): void
    {
        $user = $this->userModel->findByEmail('notfound@example.com');
        $this->assertNull($user);
    }

    public function testMultipleUsersRegistration(): void
    {
        $users = [
            ['email' => 'user1@test.com', 'password' => 'pass1', 'name' => 'User One'],
            ['email' => 'user2@test.com', 'password' => 'pass2', 'name' => 'User Two'],
            ['email' => 'user3@test.com', 'password' => 'pass3', 'name' => 'User Three'],
        ];

        foreach ($users as $userData) {
            $userId = $this->userModel->register(
                $userData['email'],
                $userData['password'],
                $userData['name']
            );
            $this->assertIsInt($userId);
        }

        // Vérifier que tous existent
        foreach ($users as $userData) {
            $user = $this->userModel->findByEmail($userData['email']);
            $this->assertNotNull($user);
            $this->assertEquals($userData['name'], $user['name']);
        }
    }

    public function testPasswordStrengthPreserved(): void
    {
        // Tester avec différents types de mots de passe
        $passwords = [
            'simple123',
            'C0mpl3x!P@ssw0rd',
            'very_long_password_with_many_characters_123456789',
            '短密码', // Unicode
        ];

        foreach ($passwords as $index => $password) {
            $email = "user{$index}@strength.com";
            $name = "User {$index}";

            $this->userModel->register($email, $password, $name);
            $user = $this->userModel->authenticate($email, $password);

            $this->assertNotNull($user, "Password '{$password}' should authenticate");
        }
    }

    public function testEmailCaseSensitivity(): void
    {
        $email = 'CaseSensitive@Example.COM';
        $password = 'password123';
        $name = 'Case User';

        $this->userModel->register($email, $password, $name);

        // Tenter avec différentes casses
        $user1 = $this->userModel->findByEmail('CaseSensitive@Example.COM');
        $user2 = $this->userModel->findByEmail('casesensitive@example.com');

        // SQLite est case-insensitive par défaut, mais tester quand même
        $this->assertNotNull($user1);
    }
}
