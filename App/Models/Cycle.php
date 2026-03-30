<?php
namespace App\Models;
use Core\BaseModel;
use PDOException;
use PDO;

class Cycle extends BaseModel{

    private string $tableName = "CYCLES";

    public function findLastByGroup($member_id){

        try{
            
            $stmt = $this->connection->prepare("SELECT c.* FROM CYCLES AS c JOIN TREATMENTS AS t ON t.cycle_id=c.cycle_id WHERE t.member_id=:member_id ORDER BY c.cycle_id ASC");
            $stmt->execute([":member_id"=>$member_id]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<br><br> CYCLE : <br>";
            var_dump($result);
            echo "<br> <br>";

        }catch (PDOException $e) {

            throw new PDOException("Problème avec la base de données");
            return false;

        }

    }
}

?>