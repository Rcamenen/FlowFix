<?php
namespace App\Models;
use Core\BaseModel;
use DateTimeImmutable;
use PDOException;
use PDO;

class CycleModel extends BaseModel{

    public function __construct()
    {
        $this->tableName = "CYCLES";
        parent::__construct();
    }

    public function findLastByGroup($member_id){

        try{
            
            $stmt = $this->connection->prepare("SELECT c.* FROM CYCLES AS c JOIN TREATMENTS AS t ON t.cycle_id=c.id WHERE t.pilot_id=:member_id ORDER BY c.id ASC");
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

    public function getCurrentCycle($teamId){

        $currentDate = new DateTimeImmutable()->format("Y-m-d h:i:s");

            $stmt = $this->connection->prepare("SELECT * FROM CYCLES WHERE end_date>:currentDate AND team_id=:teamId");
            $stmt->execute([":teamId"=>$teamId,"currentDate"=>$currentDate]);

            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            return $result;

    }
}

?>