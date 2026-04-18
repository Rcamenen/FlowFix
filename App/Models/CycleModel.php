<?php
namespace App\Models;

use Core\BaseModel;

use DateTimeImmutable;

use PDO;

class CycleModel extends BaseModel{

    public function __construct()
    {
        $this->tableName = "CYCLES";
        parent::__construct();
    }

    /** getLastByTeam()
     * Query the database to retrieve the most recent cycle for a given team, ordered by end date.
     * 
     * @param {int} $teamId : Id of the team to retrieve the last cycle for
     * @return array|false Associative array of cycle data in case of success, false if not found
     */
    public function getLastByTeam($teamId){
            
        $stmt = $this->connection->prepare("SELECT * FROM CYCLES WHERE team_id=:teamId ORDER BY end_date DESC"); //DESC -> date la plus récente
        $stmt->execute([":teamId"=>$teamId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** getCurrentCycleId()
     * Query the database to retrieve the id of the active cycle for a given team based on the current date.
     * 
     * @param {int} $teamId : Id of the team to retrieve the active cycle id for
     * @return int|false Id of the active cycle in case of success, false if not found
     */
    public function getCurrentCycleId($teamId){

        $currentDate = new DateTimeImmutable()->format("Y-m-d H:i:s");

            $stmt = $this->connection->prepare("SELECT id FROM CYCLES WHERE end_date>:currentDate AND team_id=:teamId");
            $stmt->execute([":teamId"=>$teamId,":currentDate"=>$currentDate]);

            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            return $result;

    }

    /** getCurrentCycle()
     * Query the database to retrieve the full data of the active cycle for a given team based on the current date.
     * 
     * @param {int} $teamId : Id of the team to retrieve the active cycle for
     * @return array|false Associative array of cycle data in case of success, false if not found
     */
    public function getCurrentCycle($teamId){

        $currentDate = new DateTimeImmutable()->format("Y-m-d H:i:s");

            $stmt = $this->connection->prepare("SELECT * FROM CYCLES WHERE end_date>:currentDate AND team_id=:teamId");
            $stmt->execute([":teamId"=>$teamId,":currentDate"=>$currentDate]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;

    }
}

?>