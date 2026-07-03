<?php

/**
 * Database Helper - PDO Singleton Connection
 */
class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require dirname(__DIR__) . '/Config/database.php';

            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

            try {
                self::$instance = new PDO($dsn, $config['username'], $config['password'], $config['options']);
            } catch (PDOException $e) {
                // Log error tanpa expose detail ke user
                error_log('[DB Error] ' . $e->getMessage());
                http_response_code(500);
                die('Database connection failed. Please try again later.');
            }
        }

        return self::$instance;
    }

    // Prevent cloning
    private function __construct() {}
    private function __clone() {}
}
