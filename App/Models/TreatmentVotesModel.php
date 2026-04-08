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
     * @return int
     */
    public function getVotesCounter($cycleId,$treatmentId): array {

        $stmt = $this->connection->prepare("SELECT sv.vote FROM SOLUTION_VOTES AS sv JOIN TREATMENTS AS t ON sv.treatment_id=t.id WHERE t.cycle_id=:cycleId AND sv.treatment_id=:treatmentId");
        $stmt->execute([":cycleId"=>$cycleId,":treatmentId"=>$treatmentId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }

}

?>