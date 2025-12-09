<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Model\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset singleton
        Database::resetInstance();

        // Force constantes si besoin (pas de .env requis en test)
        if (!defined('DB_DRIVER')) {
            define('DB_DRIVER', 'sqlite');
        }
        if (!defined('DB_HOST')) {
            define('DB_HOST', 'localhost');
        }
        if (!defined('DB_NAME')) {
            define('DB_NAME', ':memory:');
        }
        if (!defined('DB_USER')) {
            define('DB_USER', 'test');
        }
        if (!defined('DB_PASS')) {
            define('DB_PASS', '');
        }
        if (!defined('DB_CHARSET')) {
            define('DB_CHARSET', 'utf8mb4');
        }
    }

    public function testSingletonReturnsSameInstance(): void
    {
        $db1 = Database::getInstance();
        $db2 = Database::getInstance();

        $this->assertSame($db1, $db2);
        $this->assertInstanceOf(Database::class, $db1);
    }

    public function testLazyLoadingPdoIsCreatedOnlyOnce(): void
    {
        $db = Database::getInstance();

        $pdo1 = $db->getPDO();
        $this->assertInstanceOf(PDO::class, $pdo1);

        $pdo2 = $db->getPDO();
        $this->assertSame($pdo1, $pdo2);
    }

    public function testPdoErrorModeIsException(): void
    {
        $db = Database::getInstance();
        $pdo = $db->getPDO();

        $errorMode = $pdo->getAttribute(PDO::ATTR_ERRMODE);
        $this->assertEquals(PDO::ERRMODE_EXCEPTION, $errorMode);
    }

    public function testPdoDefaultFetchModeIsAssoc(): void
    {
        $db = Database::getInstance();
        $pdo = $db->getPDO();

        $fetchMode = $pdo->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);
        $this->assertEquals(PDO::FETCH_ASSOC, $fetchMode);
    }
}
