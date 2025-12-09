<?php

declare(strict_types=1);

namespace App\Model;

use PDOStatement;

/**
 * Wrapper pour queries, counting, etc.
 */
class DatabaseWrapper
{
    /** @var DatabaseWrapper|null */
    private static ?DatabaseWrapper $instance = null;

    private Database $db;

    private function __construct()
    {
        $this->db = Database::getInstance();
    }

    public static function getInstance(): DatabaseWrapper
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseWrapper();
        }

        return self::$instance;
    }

    public function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = $this->db->getPDO()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function fetch(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();

        return $result !== false ? $result : null;
    }

    public function insert(string $sql, array $params = []): int
    {
        $this->query($sql, $params);

        return (int) $this->db->getPDO()->lastInsertId();
    }

    public static function resetInstance(): void
    {
        self::$instance = null;
    }
}
