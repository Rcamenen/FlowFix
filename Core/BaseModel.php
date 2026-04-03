<?php
namespace Core;

use PDO;
use PDOException;

abstract class BaseModel {

    protected $connection;
    protected string $tableName;

    public function __construct() {

            $this->connection = Database::getInstance()->getConnection();
            
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

        $stmt = $this->connection->prepare("SELECT * FROM ".$this->tableName." WHERE id=:id");
        $stmt->execute([":id"=>$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function getFieldsByFilters(array $fields,array $filters,string $fetch="assoc"){

        $propsStr = implode(",",$fields);

        foreach($filters as $key => $value){

            $bindingArray[":".$key] = $value;
            $filterArray[]=$key."=:".$key;

        }

        $filtersStr = implode(" AND ",$filterArray);

        $stmt = $this->connection->prepare("SELECT ".$propsStr." FROM ".$this->tableName." WHERE ".$filtersStr);

        $stmt -> execute($bindingArray);

        switch($fetch){

            case "assoc":
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
            case "column":
                return $stmt->fetchAll(PDO::FETCH_COLUMN);
                break;
            case "both":
                return $stmt->fetchAll(PDO::FETCH_BOTH);
                break;
            default:
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
                break;
        }

    }


    public function create($array){

        $propsStr = implode(",",array_keys($array));
        $valuesStr = ":".implode(",:",array_keys($array));

        foreach($array as $key => $value){

            $bindingArray[":".$key] = $value;

        }

        $stmt = $this->connection->prepare("INSERT INTO ".$this->tableName."(".$propsStr.") values(".$valuesStr.")");

        $stmt -> execute($bindingArray);

    }

    public function createTestObject(object $entity){

        $entityArray = $entity->toArray();

        foreach($entityArray as $key=>$value){

            if($value===null) unset($entityArray[$key]);
            if(gettype($value)==="object")$entityArray[$key] = $value->format("Y-m-d h:i:s");

        }

        $propsStr = implode(",",array_keys($entityArray));
        $valuesStr = ":".implode(",:",array_keys($entityArray));

        foreach($entityArray as $key => $value){

            $bindingArray[":".$key] = $value;

        }

        $stmt = $this->connection->prepare("INSERT INTO ".$this->tableName."(".$propsStr.") values(".$valuesStr.")");

        $stmt -> execute($bindingArray);

        return ($stmt) ? $entity : false;

    }


}

?>