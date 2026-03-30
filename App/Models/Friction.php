<?php
namespace App\Models;
use Core\BaseModel;
use PDO;
use PDOException;

class Friction extends BaseModel{

    public function findById($frictionId){

        $stmt = $this->connection->prepare("SELECT * FROM FRICTIONS WHERE friction_id=:friction_id");
        $stmt->execute([":friction_id"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<br> FRICTION : <br>";
        var_dump($result);

        return $result;

    }
    
}

?>