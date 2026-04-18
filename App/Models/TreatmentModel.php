<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class TreatmentModel extends BaseModel{

    public function __construct(){

        $this->tableName = "TREATMENTS";
        parent::__construct();

    }

    /** findLastsByFrictionWithStatus()
     * Query the database to retrieve the most recent treatments for a given friction,
     * enriched with their status label, ordered by id descending.
     * 
     * @param {int} $frictionId : Id of the friction to retrieve treatments for
     * @param {int} $limit : Maximum number of results to return
     * @return array Array of treatments as associative arrays, empty array if none found
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
     * by joining treatments, team members & users tables.
     * 
     * @param {int} $treatmentId : Id of the treatment to retrieve the pilot for
     * @return string|false Pilot's username in case of success, false if not found
     */
    public function getPilotUsername($treatmentId){

        $stmt = $this->connection->prepare("SELECT u.username FROM TREATMENTS AS t JOIN TEAM_MEMBERS AS tm ON t.pilot_id=tm.id JOIN USERS AS u ON tm.user_id=u.id WHERE t.id=:treatmentId");
        $stmt->execute([":treatmentId"=>$treatmentId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

}

?>