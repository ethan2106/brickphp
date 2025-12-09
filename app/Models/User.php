<?php

declare(strict_types=1);

namespace App\Models;

use BrickPHP\Core\Model;

/**
 * User Model
 * 
 * Example model demonstrating BrickPHP ORM usage.
 */
class User extends Model
{
    protected string $table = 'users';
    protected string $primaryKey = 'id';
    
    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?array
    {
        $users = $this->where(['email' => $email]);
        return $users[0] ?? null;
    }
    
    /**
     * Find active users
     */
    public function findActive(): array
    {
        return $this->where(['status' => 'active']);
    }
    
    /**
     * Create new user with hashed password
     */
    public function createUser(array $data): int
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->create($data);
    }
    
    /**
     * Update user password
     */
    public function updatePassword(int $userId, string $newPassword): int
    {
        return $this->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
    
    /**
     * Verify password
     */
    public function verifyPassword(array $user, string $password): bool
    {
        return password_verify($password, $user['password'] ?? '');
    }
}
