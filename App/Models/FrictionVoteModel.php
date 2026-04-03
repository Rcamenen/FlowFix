<?php
namespace App\Models;
use Core\BaseModel;
use PDO;
use PDOException;

class FrictionVoteModel extends BaseModel{
    public function __construct(){
        $this->tableName = "FRICTIONS";
        parent::__construct();
    }



    public function getVotesCounter($cycleId,$frictionId): int {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM FRICTION_VOTES WHERE cycle_id=:cycleId AND friction_id=:frictionId AND vote=1");

        $stmt->execute([":cycleId"=>$cycleId,":frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }
}

?>