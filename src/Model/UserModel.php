<?php

/**
 * Exemple de modèle User
 */

declare(strict_types=1);

namespace App\Model;

class UserModel extends BaseModel
{
    protected string $table = 'users';

    /**
     * Trouve un utilisateur par email
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";

        return $this->db->fetch($sql, [$email]);
    }

    /**
     * Crée un utilisateur avec mot de passe hashé
     */
    public function register(string $email, string $password, string $name): int
    {
        return $this->create([
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'name' => $name,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Vérifie les identifiants
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if ($user !== null && password_verify($password, $user['password'])) {
            unset($user['password']); // Ne pas exposer le hash

            return $user;
        }

        return null;
    }
}
