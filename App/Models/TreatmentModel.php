<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class TreatmentModel extends BaseModel{

    public function __construct(){

        $this->tableName = "TREATMENTS";
        parent::__construct();

    }

    /** findByPilot()
     * Query the database to retrieve the most recent treatment assigned to a given team member as pilot
     * Return the result as an associative array or false if not found
     * @param int $member_id
     * @return array|false
     */
    public function findByPilot($member_id){

        $stmt = $this->connection->prepare("SELECT t.* FROM TREATMENTS AS t JOIN CYCLES AS c ON t.cycle_id=c.id WHERE t.pilot_id=:member_id ORDER BY c.start_date DESC");
        $stmt->execute([":member_id"=>$member_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    /** isPilot()
     * Query the database to check if a given team member is assigned as pilot to any treatment
     * Return the count as an integer
     * @param int $member_id
     * @return int
     */
    public function isPilot($member_id){

        $stmt = $this->connection->prepare("SELECT count(*) FROM TREATMENTS WHERE pilot_id=:member_id");
        $stmt->execute([":member_id"=>$member_id]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** findLastsByFrictionWithStatus()
     * Query the database to retrieve the most recent treatments for a given friction along with their status details
     * Return the results as an array
     * @param int $frictionId
     * @param int $limit
     * @return array
     */
    public function findLastsByFrictionWithStatus(int $frictionId, int $limit): array {

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
                LIMIT :limit"
            );
        $stmt->bindValue(":frictionId", $frictionId, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    /** getPilotUsername()
     * Query the database to retrieve the username of the pilot assigned to a given treatment
     * Return the username as a string or false if not found
     * @param int $treatmentId
     * @return string|false
     */
    public function getPilotUsername($treatmentId){

        $stmt = $this->connection->prepare("SELECT u.username FROM TREATMENTS AS t JOIN TEAM_MEMBERS AS tm ON t.pilot_id=tm.id JOIN USERS AS u ON tm.user_id=u.id WHERE t.id=:treatmentId");
        $stmt->execute([":treatmentId"=>$treatmentId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

}

?>