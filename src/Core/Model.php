<?php

declare(strict_types=1);

namespace BrickPHP\Core;

use BrickPHP\Database\Database;

/**
 * Base Model Class
 * 
 * All application models should extend this class.
 */
abstract class Model
{
    protected Database $db;
    protected string $table = '';
    protected string $primaryKey = 'id';
    
    public function __construct()
    {
        $app = Application::getInstance();
        $this->db = $app->getContainer()->make(Database::class);
    }
    
    /**
     * Find record by ID
     */
    public function find(int|string $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        return $this->db->fetchOne($sql, [':id' => $id]);
    }
    
    /**
     * Get all records
     */
    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Create new record
     */
    public function create(array $data): int
    {
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Update record
     */
    public function update(int|string $id, array $data): int
    {
        return $this->db->update($this->table, $data, [$this->primaryKey => $id]);
    }
    
    /**
     * Delete record
     */
    public function delete(int|string $id): int
    {
        return $this->db->delete($this->table, [$this->primaryKey => $id]);
    }
    
    /**
     * Find records by criteria
     */
    public function where(array $criteria): array
    {
        $whereClause = [];
        $params = [];
        
        foreach ($criteria as $column => $value) {
            $whereClause[] = "{$column} = :{$column}";
            $params[":{$column}"] = $value;
        }
        
        $sql = sprintf(
            "SELECT * FROM %s WHERE %s",
            $this->table,
            implode(' AND ', $whereClause)
        );
        
        return $this->db->fetchAll($sql, $params);
    }
    
    /**
     * Get database instance
     */
    protected function getDb(): Database
    {
        return $this->db;
    }
}
