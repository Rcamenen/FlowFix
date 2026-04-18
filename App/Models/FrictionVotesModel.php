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
     * Query the database to count the number of positive votes for a given friction within a specific cycle.
     * 
     * @param {int} $cycleId : Id of the cycle to filter by
     * @param {int} $frictionId : Id of the friction to count votes for
     * @return int Total number of positive votes
     */
    public function getVotesCounter($cycleId,$frictionId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM FRICTION_VOTES WHERE cycle_id=:cycleId AND friction_id=:frictionId AND vote=1");

        $stmt->execute([":cycleId"=>$cycleId,":frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** getCounterByMemberAndTeam()
     * Query the database to count the number of positive votes cast by a given member within a specific cycle.
     * 
     * @param {int} $cycleId : Id of the cycle to filter by
     * @param {int} $teamMemberId : Id of the team member to count votes for
     * @return int Total number of positive votes cast by the member
     */
    public function getCounterByMemberAndTeam($cycleId,$teamMemberId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM FRICTION_VOTES WHERE member_id=:teamMemberId AND cycle_id=:cycleId AND vote=1");

        $stmt->execute([":teamMemberId"=>$teamMemberId,":cycleId"=>$cycleId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** findMostVotedByCycle()
     * Query the database to retrieve the ids of the most voted frictions for a given cycle,
     * limited to the team's maximum treatments preset.
     * 
     * @param {int} $cycleId : Id of the cycle to filter by
     * @param {int} $maxTreatments : Maximum number of friction ids to return
     * @return array Array of friction ids ordered by vote count descending
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