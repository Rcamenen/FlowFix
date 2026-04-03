<?php
namespace App\Models;
use Core\BaseModel;
use PDO;

class TreatmentVoteModel extends BaseModel{


    public function getVotesCounter($cycleId,$treatmentId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(sv.id) FROM SOLUTION_VOTES AS sv JOIN TREATMENTS AS t ON sv.treatment_id=t.id WHERE t.cycle_id=:cycleId AND sv.treatment_id=:treatmentId AND vote=1");
        $stmt->execute([":cycleId"=>$cycleId,":treatmentId"=>$treatmentId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

}

?>