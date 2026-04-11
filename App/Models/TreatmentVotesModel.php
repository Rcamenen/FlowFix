<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class TreatmentVotesModel extends BaseModel{

    /** getVotesCounter()
     * Query the database to count the number of positive votes for a given treatment within a specific cycle
     * Return the total count as an integer
     * @param int $cycleId
     * @param int $treatmentId
     * @return array
     */
    public function getVotesByCycleAndTreatment($cycleId,$treatmentId): array {

        $stmt = $this->connection->prepare("SELECT sv.vote FROM SOLUTION_VOTES AS sv JOIN TREATMENTS AS t ON sv.treatment_id=t.id WHERE t.cycle_id=:cycleId AND sv.treatment_id=:treatmentId");
        $stmt->execute([":cycleId"=>$cycleId,":treatmentId"=>$treatmentId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }

    public function getVotesCounter($cycleId,$treatmentId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM FRICTION_VOTES WHERE cycle_id=:cycleId AND friction_id=:treatmentId AND vote=1");

        $stmt->execute([":cycleId"=>$cycleId,":treatmentId"=>$treatmentId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** findVotesByTreatmentAndCycle()
     * Query the database to retrieve all votes for a given treatment within a specific cycle
     * Return the votes as an array
     * @param int $treatmentId
     * @param int $cycleId
     * @return array
     */
    public function findVotesByTreatmentAndCycle(int $treatmentId, int $cycleId): array {

        $stmt = $this->connection->prepare("SELECT sv.vote FROM SOLUTION_VOTES AS sv JOIN TREATMENTS AS t ON sv.treatment_id=t.id WHERE t.cycle_id=:cycleId AND t.id=:treatmentId");
        $stmt->execute([":treatmentId" => $treatmentId, ":cycleId" => $cycleId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }


    /** findVotesByTreatmentAndStatus()
     * Query the database to retrieve all votes for a given treatment within a specific status
     * Return the votes as an array
     * @param int $treatmentId
     * @param int $statusId
     * @return array
     */
    public function findVotesByTreatmentAndStatus(int $treatmentId,int $statusId):array{

        $stmt = $this->connection->prepare("SELECT sv.vote FROM SOLUTION_VOTES AS sv JOIN TREATMENTS AS t ON sv.treatment_id=t.id WHERE t.status_id=:statusId AND t.id=:treatmentId");
        $stmt->execute([":treatmentId"=>$treatmentId,":statusId"=>$statusId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }
    
}

?>