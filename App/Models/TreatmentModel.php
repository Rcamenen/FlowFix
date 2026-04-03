<?php
namespace App\Models;
use Core\BaseModel;
use PDO;
use PDOException;

class TreatmentModel extends BaseModel{
    
    public function findByPilot($member_id){

        $stmt = $this->connection->prepare("SELECT t.* FROM TREATMENTS AS t JOIN CYCLES AS c ON t.cycle_id=c.id WHERE t.pilot_id=:member_id ORDER BY c.start_date DESC");
        $stmt->execute([":member_id"=>$member_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    public function isPilot($member_id){

        $stmt = $this->connection->prepare("SELECT count(*) FROM TREATMENTS WHERE pilot_id=:member_id");
        $stmt->execute([":member_id"=>$member_id]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    public function getLastByFrictionWithStatus($frictionId){

        $stmt = $this->connection->prepare(
            "SELECT 
                t.id,
                t.solution,
                t.created_at,
                t.updated_at,
                t.pilot_id,
                t.cycle_id,
                t.friction_id,
                ts.id AS status_id,
                ts.label
                FROM TREATMENTS AS t 
                JOIN TREATMENT_STATUS AS ts ON t.status_id = ts.id 
                WHERE t.friction_id = :frictionId 
                ORDER BY t.id DESC 
                LIMIT 1"
            );
        $stmt->execute([":frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    public function getPilotUsername($treatmentId){

        $stmt = $this->connection->prepare("SELECT u.username FROM TREATMENTS AS t JOIN TEAM_MEMBERS AS tm ON t.pilot_id=tm.id JOIN USERS AS u ON tm.user_id=u.id WHERE t.id=:treatmentId");
        $stmt->execute([":treatmentId"=>$treatmentId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

}

?>