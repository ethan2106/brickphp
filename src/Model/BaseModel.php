<?php

/**
 * Modèle de base - À étendre pour chaque entité
 */

declare(strict_types=1);

namespace App\Model;

abstract class BaseModel
{
    protected Database $db;
    protected string $table;
    protected string $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Trouve un enregistrement par ID
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";

        return $this->db->fetch($sql, [$id]);
    }

    /**
     * Récupère tous les enregistrements
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";

        return $this->db->fetchAll($sql);
    }

    /**
     * Trouve par condition
     */
    public function where(string $column, mixed $value): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";

        return $this->db->fetchAll($sql, [$value]);
    }

    /**
     * Crée un enregistrement
     */
    public function create(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        return $this->db->insert($sql, array_values($data));
    }

    /**
     * Met à jour un enregistrement
     */
    public function update(int $id, array $data): bool
    {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = ?";

        $params = array_values($data);
        $params[] = $id;

        $this->db->query($sql, $params);

        return true;
    }

    /**
     * Supprime un enregistrement
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $this->db->query($sql, [$id]);

        return true;
    }
}
