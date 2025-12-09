<?php

declare(strict_types=1);

namespace BrickPHP\Database;

use PDO;
use PDOException;

/**
 * Database Connection Manager
 * 
 * Handles PDO connections with security features.
 */
class Database
{
    private ?PDO $pdo = null;
    private array $config;
    
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * Get PDO connection
     */
    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            $this->connect();
        }
        
        return $this->pdo;
    }
    
    /**
     * Establish database connection
     */
    private function connect(): void
    {
        $driver = $this->config['driver'] ?? 'mysql';
        $host = $this->config['host'] ?? 'localhost';
        $port = $this->config['port'] ?? 3306;
        $database = $this->config['database'] ?? '';
        $username = $this->config['username'] ?? '';
        $password = $this->config['password'] ?? '';
        $charset = $this->config['charset'] ?? 'utf8mb4';
        
        $dsn = "{$driver}:host={$host};port={$port};dbname={$database};charset={$charset}";
        
        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Execute query with prepared statement (SQL injection protection)
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $pdo = $this->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt;
    }
    
    /**
     * Fetch all results
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }
    
    /**
     * Fetch single result
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();
        return $result ?: null;
    }
    
    /**
     * Insert record and return last insert ID
     */
    public function insert(string $table, array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":{$col}", $columns);
        
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );
        
        $params = [];
        foreach ($data as $key => $value) {
            $params[":{$key}"] = $value;
        }
        
        $this->query($sql, $params);
        
        return (int)$this->getConnection()->lastInsertId();
    }
    
    /**
     * Update records
     */
    public function update(string $table, array $data, array $where): int
    {
        $setClause = [];
        foreach (array_keys($data) as $column) {
            $setClause[] = "{$column} = :{$column}";
        }
        
        $whereClause = [];
        foreach (array_keys($where) as $column) {
            $whereClause[] = "{$column} = :where_{$column}";
        }
        
        $sql = sprintf(
            "UPDATE %s SET %s WHERE %s",
            $table,
            implode(', ', $setClause),
            implode(' AND ', $whereClause)
        );
        
        $params = [];
        foreach ($data as $key => $value) {
            $params[":{$key}"] = $value;
        }
        foreach ($where as $key => $value) {
            $params[":where_{$key}"] = $value;
        }
        
        $stmt = $this->query($sql, $params);
        
        return $stmt->rowCount();
    }
    
    /**
     * Delete records
     */
    public function delete(string $table, array $where): int
    {
        $whereClause = [];
        foreach (array_keys($where) as $column) {
            $whereClause[] = "{$column} = :{$column}";
        }
        
        $sql = sprintf(
            "DELETE FROM %s WHERE %s",
            $table,
            implode(' AND ', $whereClause)
        );
        
        $params = [];
        foreach ($where as $key => $value) {
            $params[":{$key}"] = $value;
        }
        
        $stmt = $this->query($sql, $params);
        
        return $stmt->rowCount();
    }
    
    /**
     * Begin transaction
     */
    public function beginTransaction(): bool
    {
        return $this->getConnection()->beginTransaction();
    }
    
    /**
     * Commit transaction
     */
    public function commit(): bool
    {
        return $this->getConnection()->commit();
    }
    
    /**
     * Rollback transaction
     */
    public function rollback(): bool
    {
        return $this->getConnection()->rollBack();
    }
}
