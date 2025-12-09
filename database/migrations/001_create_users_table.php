<?php

declare(strict_types=1);

use BrickPHP\Database\Migration;

/**
 * Create users table migration
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->createTable('users', [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'email' => 'VARCHAR(255) NOT NULL UNIQUE',
            'password' => 'VARCHAR(255) NOT NULL',
            'name' => 'VARCHAR(255) NOT NULL',
            'status' => "ENUM('active', 'inactive') DEFAULT 'active'",
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
    }
    
    public function down(): void
    {
        $this->dropTable('users');
    }
};
