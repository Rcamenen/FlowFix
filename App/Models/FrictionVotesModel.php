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

    /** getCounterByMemberAndTeam()
     * Query the database to count the number of votes for a given member on a given cycle (so a given team...)
     * Return the total count as an integer
     * @param int $cycleId
     * @param int $frictionId
     * @return int
     */
    public function getCounterByMemberAndTeam($cycleId,$teamMemberId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM FRICTION_VOTES WHERE member_id=:teamMemberId AND cycle_id=:cycleId AND vote=1");

        $stmt->execute([":teamMemberId"=>$teamMemberId,":cycleId"=>$cycleId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** findMostVotedByCycle()
     * Query the database to retrieve the most voted frictions for a given cycle and limit (team's max treatments preset).
     * @param int $cycleId
     * @param int $maxTreatments
     * @return array
     */
    public function findMostVotedByCycle(int $cycleId,int $maxTreatments):array{

        $stmt = $this->connection->prepare("SELECT friction_id FROM FRICTION_VOTES WHERE cycle_id=:cycleId GROUP BY friction_id ORDER BY COUNT(friction_id) DESC LIMIT :maxTreatments");

        //bindValue obligatoire pour utilisation d'un int en limit
        $stmt->bindValue(":cycleId", $cycleId, PDO::PARAM_INT);
        $stmt->bindValue(":maxTreatments", $maxTreatments, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);

    }
}

?>