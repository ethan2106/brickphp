<?php

declare(strict_types=1);

namespace BrickPHP\Database;

/**
 * Database Migration
 * 
 * Base class for database migrations.
 */
abstract class Migration
{
    protected Database $db;
    
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    
    /**
     * Run the migration
     */
    abstract public function up(): void;
    
    /**
     * Reverse the migration
     */
    abstract public function down(): void;
    
    /**
     * Create table
     */
    protected function createTable(string $table, array $columns): void
    {
        $columnDefs = [];
        
        foreach ($columns as $name => $definition) {
            $columnDefs[] = "`{$name}` {$definition}";
        }
        
        $sql = sprintf(
            "CREATE TABLE IF NOT EXISTS `%s` (%s) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
            $table,
            implode(', ', $columnDefs)
        );
        
        $this->db->query($sql);
    }
    
    /**
     * Drop table
     */
    protected function dropTable(string $table): void
    {
        $sql = "DROP TABLE IF EXISTS `{$table}`";
        $this->db->query($sql);
    }
}
