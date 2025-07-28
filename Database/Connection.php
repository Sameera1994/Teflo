<?php
namespace Teflo\Core\Database;

use PDO;

class Connection {
    private static $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $host = 'localhost';
            $dbname = 'teflo_db';
            $username = 'root';
            $password = '';

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            self::$instance = new PDO($dsn, $username, $password);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}

?>