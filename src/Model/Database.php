<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use PDOException;
use RuntimeException;

/**
 * Connexion PDO Singleton
 */
class Database
{
    /** @var Database|null */
    private static ?Database $instance = null;
    private ?PDO $pdo = null;

    private function __construct()
    {
        // lazy connection
    }

    private function connect(): void
    {
        if ($this->pdo !== null) {
            return;
        }

        // SQLite mode (for tests)
        if (defined('DB_DRIVER') && defined('DB_NAME')) {
            /** @var string $driver */
            $driver = DB_DRIVER;
            if ($driver === 'sqlite') {
                $dsn = 'sqlite:' . DB_NAME;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                $this->pdo = new PDO($dsn, null, null, $options);

                return;
            }
        }

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST,
            DB_NAME,
            DB_CHARSET
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (defined('APP_DEBUG') && APP_DEBUG) {
                throw $e;
            }
            throw new RuntimeException('Erreur de connexion à la base de données.');
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getPDO(): PDO
    {
        $this->connect();
        assert($this->pdo !== null, 'PDO should be initialized after connect()');

        return $this->pdo;
    }

    public static function resetInstance(): void
    {
        self::$instance = null;
    }

    /**
     * Execute a query with parameters
     */
    public function query(string $sql, array $params = []): bool
    {
        $stmt = $this->getPDO()->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * Fetch a single row
     */
    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->getPDO()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result !== false ? $result : null;
    }

    /**
     * Fetch all rows
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->getPDO()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insert and return last insert id
     */
    public function insert(string $sql, array $params = []): int
    {
        $stmt = $this->getPDO()->prepare($sql);
        $stmt->execute($params);

        return (int) $this->getPDO()->lastInsertId();
    }
}
