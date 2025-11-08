<?php
class DatabaseConfig {
    public static $host = 'localhost';
    public static $port = '5432';
    public static $dbname = 'agi';
    public static $user = 'postgres';
    public static $password = 'postgres';
    
    public static function getConnection() {
        try {
            $dsn = "pgsql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname;
            $pdo = new PDO($dsn, self::$user, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->exec("SET NAMES 'UTF8'");
            return $pdo;
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            return false;
        }
    }
}
?>