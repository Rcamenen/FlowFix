<?php
namespace Core;
use PDO;
use PDOException;

abstract class BaseModel {

    protected $connection;

    public function __construct() {
        try{

            $this->connection = Database::getInstance()->getConnection();

        }catch(PDOException $e){

            echo "Error BaseModel.php";

        }
    }

    public function getAll(){


        try{
            
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->tableName);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e) {

            echo $e->getMessage();
            return false;

        }

    }

    public function getById($id){

        try{
            
            $stmt = $this->connection->prepare("SELECT * FROM ".$this->tableName." WHERE ".$this->idField."=:id");
            $stmt->execute([":id"=>$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

        }catch(PDOException $e) {

            echo $e->getMessage();
            return false;

        }

    }


}

?>