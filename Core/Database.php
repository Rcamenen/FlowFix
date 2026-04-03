<?php
namespace Core;
use Exception;
use PDO;

class Database {
    private static ?self $instance = null;
    private PDO $connection;

    private function __construct() {

        $this->connection = new PDO("mysql:
            host=".$_ENV['DB_HOST'].";
            dbname=".$_ENV['DB_NAME'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}

?>