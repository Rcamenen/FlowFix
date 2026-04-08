<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class FrictionVotesModel extends BaseModel{
    public function __construct(){
        $this->tableName = "FRICTION_VOTES";
        parent::__construct();
    }

    /** getVotesCounter()
     * Query the database to count the number of positive votes for a given friction within a specific cycle
     * Return the total count as an integer
     * @param int $cycleId
     * @param int $frictionId
     * @return int
     */
    public function getVotesCounter($cycleId,$frictionId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM FRICTION_VOTES WHERE cycle_id=:cycleId AND friction_id=:frictionId AND vote=1");

        $stmt->execute([":cycleId"=>$cycleId,":frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    public function getCounterByMemberAndTeam($cycleId,$teamMemberId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM FRICTION_VOTES WHERE member_id=:teamMemberId AND cycle_id=:cycleId AND vote=1");

        $stmt->execute([":teamMemberId"=>$teamMemberId,":cycleId"=>$cycleId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    public function getCounterBy(array $filters){

        foreach($filters as $key => $value){

            $bindingArray[":".$key] = $value;
            $filterArray[]=$key."=:".$key;

            }

            $filtersStr = implode(" AND ",$filterArray);

            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM ".$this->tableName." WHERE ".$filtersStr);

            $stmt -> execute($bindingArray);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }
}

?>