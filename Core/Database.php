<?php
namespace Core;
use PDO;

class Database {
    private static ?self $instance = null;
    private PDO $connection;

    private function __construct() {
        try{

            $this->connection = new PDO("mysql:
                host=".$_ENV['DB_HOST'].";
                dbname=".$_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

        }catch(Exception $e){
            echo "Error Database.php";
        }
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