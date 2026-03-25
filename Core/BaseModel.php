<?php
namespace Core;

abstract class BaseModel {
    protected $connection;

    public function __construct() {
        try{

            $this->connection = Database::getInstance()->getConnection();

        }catch(PDOException $e){

            echo "Error BaseModel.php";

        }
    }
}

?>