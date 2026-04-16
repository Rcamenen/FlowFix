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

    /** getLastByGroup()
     * Query the database to retrieve the last cycle associated with a given team member ordered by ID
     * Return the result as an associative array
     * @param int $member_id
     * @return array
     */
    public function getLastByTeam($teamId){
            
        $stmt = $this->connection->prepare("SELECT * FROM CYCLES WHERE team_id=:teamId ORDER BY end_date DESC"); //DESC -> date la plus récente
        $stmt->execute([":teamId"=>$teamId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** getCurrentCycleId()
     * Query the database to retrieve the active cycle for a given team based on the current date
     * Return the cycle ID or false if no active cycle is found
     * @param int $teamId
     * @return int|false
     */
    public function getCurrentCycleId($teamId){

        $currentDate = new DateTimeImmutable()->format("Y-m-d H:i:s");

            $stmt = $this->connection->prepare("SELECT id FROM CYCLES WHERE end_date>:currentDate AND team_id=:teamId");
            $stmt->execute([":teamId"=>$teamId,":currentDate"=>$currentDate]);

            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            return $result;

    }

    /** getCurrentCycleId()
     * Query the database to retrieve the active cycle for a given team based on the current date
     * Return the cycle ID or false if no active cycle is found
     * @param int $teamId
     * @return int|false
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