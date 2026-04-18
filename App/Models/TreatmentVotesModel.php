<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class TreatmentVotesModel extends BaseModel{

    public function __construct(){

        $this->tableName = "SOLUTION_VOTES";
        parent::__construct();

    }

    /** findVotesByTreatmentAndCycle()
     * Query the database to retrieve all vote values for a given treatment within a specific cycle.
     * 
     * @param {int} $treatmentId : Id of the treatment to retrieve votes for
     * @param {int} $cycleId : Id of the cycle to filter by
     * @return array Array of vote values, empty array if none found
     */
    public function findVotesByTreatmentAndCycle(int $treatmentId, int $cycleId): array {

        $stmt = $this->connection->prepare("SELECT sv.vote FROM SOLUTION_VOTES AS sv JOIN TREATMENTS AS t ON sv.treatment_id=t.id WHERE t.cycle_id=:cycleId AND t.id=:treatmentId");
        $stmt->execute([":treatmentId" => $treatmentId, ":cycleId" => $cycleId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }


    /** findVotesByTreatmentAndStatus()
     * Query the database to retrieve all vote values for a given treatment filtered by treatment status.
     * 
     * @param {int} $treatmentId : Id of the treatment to retrieve votes for
     * @param {int} $statusId : Id of the treatment status to filter by
     * @return array Array of vote values, empty array if none found
     */
    public function findVotesByTreatmentAndStatus(int $treatmentId,int $statusId):array{

        $stmt = $this->connection->prepare("SELECT sv.vote FROM SOLUTION_VOTES AS sv JOIN TREATMENTS AS t ON sv.treatment_id=t.id WHERE t.status_id=:statusId AND t.id=:treatmentId");
        $stmt->execute([":treatmentId"=>$treatmentId,":statusId"=>$statusId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }
    
}

?>