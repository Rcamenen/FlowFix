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

    /** getAll()
     * Query the database to retrieve all records from the model's table
     * Return the results as an array of associative arrays or false on failure
     * @param {*}
     * @return array|false
     */
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

    /** getById()
     * Query the database to retrieve a single record matching the given ID from the model's table
     * Return the result as an associative array or false if not found
     * @param int $id
     * @return array|false
     */
    public function getById($id) : array|false {

        $stmt = $this->connection->prepare("SELECT * FROM ".$this->tableName." WHERE id=:id");
        $stmt->execute([":id"=>$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    /** findBy()
     * Build and execute a dynamic query to retrieve specific fields matching the given filters from the model's table
     * Return the results in the specified fetch format
     * @param array $fields
     * @param array $filters
     * @param string $fetch
     * @return array|string|int|false
     */
    public function findBy(array $fields,?array $filters=null,string $fetch="assoc"){

        $propsStr = implode(",",$fields);

        if(!empty($filters)){

            foreach($filters as $key => $value){

            $bindingArray[":".$key] = $value;
            $filterArray[]=$key."=:".$key;

            }

            $filtersStr = implode(" AND ",$filterArray);

            $stmt = $this->connection->prepare("
                    SELECT ".$propsStr.
                    " FROM ".$this->tableName.
                    " WHERE ".$filtersStr);

            $stmt -> execute($bindingArray);

        }else{

            $stmt = $this->connection->prepare("
                    SELECT ".$propsStr.
                    " FROM ".$this->tableName);

            $stmt -> execute();

        }

        

        switch($fetch){

            case "assoc":
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            case "column":
                return $stmt->fetchAll(PDO::FETCH_COLUMN);
            case "both":
                return $stmt->fetchAll(PDO::FETCH_BOTH);
            case "onecolumn":
                return $stmt->fetch(PDO::FETCH_COLUMN);
            case "oneassoc":
                return $stmt->fetch(PDO::FETCH_ASSOC);
            default:
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }

    /** create()
     * Build and execute a dynamic INSERT query from the given associative array to create a new record in the model's table
     * @param array $array
     * @return int
     */
    public function create($array):int{

        $propsStr = implode(",",array_keys($array));
        $valuesStr = ":".implode(",:",array_keys($array));

        foreach($array as $key => $value){

            $bindingArray[":".$key] = $value;

        }

        $stmt = $this->connection->prepare("INSERT INTO ".$this->tableName."(".$propsStr.") values(".$valuesStr.")");

        $stmt -> execute($bindingArray);

        return (int) $this->connection->lastInsertId();

    }

    /** delete()
     * Build and execute a DELETE query to remove a record by its id in the model's table
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {

        $stmt = $this->connection->prepare("DELETE FROM " . $this->tableName . " WHERE id = :id");
        $result = $stmt->execute([":id" => $id]);

        return $result;

    }

    /** update()
     * Build and execute a dynamic UPDATE query from the given associative array to update an existing record in the model's table
     * @param int $id
     * @param array $array
     * @return bool
     */
    public function update(int $id, array $array): bool {

        $propsStr = implode(", ", array_map(fn($key) => $key." = :".$key, array_keys($array)));

        foreach($array as $key => $value){
            $bindingArray[":".$key] = $value;
        }
        $bindingArray[":id"] = $id;

        $stmt = $this->connection->prepare("UPDATE ".$this->tableName." SET ".$propsStr." WHERE id = :id");

        $result = $stmt->execute($bindingArray);

        return $result;

    }

    /** findAllPaginated()
     * Build and execute a paginated SELECT query to retrieve all records from the model's table
     * Return the results as an array of associative arrays
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAllPaginated(int $limit, int $offset): array {

        $stmt = $this->connection->prepare("SELECT * FROM " . $this->tableName . " ORDER BY id DESC LIMIT :limit OFFSET :offset");

        $stmt->bindValue(":limit",  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /** countAll()
     * Execute a COUNT query to retrieve the total number of records in the model's table
     * Return the result as an integer
     * @return int
     */
    public function countAll(): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM " . $this->tableName);

        $stmt->execute();

        return (int) $stmt->fetch(PDO::FETCH_COLUMN);

    }

}

?>