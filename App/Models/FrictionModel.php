<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class FrictionModel extends BaseModel{

    public function __construct()
    {
        $this->tableName = "FRICTIONS";
        parent::__construct();
    }



    /** isOwnByTeam()
     * Query the database to check if a friction belongs to a given team
     * by joining frictions with team members.
     * 
     * @param {int} $author : Id of the friction's author (team member id)
     * @param {int} $teamId : Id of the team to check against
     * @return bool True if the friction belongs to the team, false otherwise
     */
    public function isOwnByTeam(int $author, int $teamId): bool {

        $stmt = $this->connection->prepare(
            "SELECT COUNT(*) 
            FROM FRICTIONS AS f
            JOIN TEAM_MEMBERS AS tm ON f.author_id = tm.id
            WHERE f.author_id = :author AND tm.team_id = :teamId"
        );
        $stmt->execute([":author" => $author, ":teamId" => $teamId]);

        return (bool) $stmt->fetch(PDO::FETCH_COLUMN);

    }
    
    /** findByGroupAndStatus()
     * Query the database to retrieve all frictions matching a given team and status.
     * 
     * @param {int} $teamId : Id of the team to filter by
     * @param {int} $statusId : Id of the status to filter by
     * @return array Array of matching frictions as associative arrays, empty array if none found
     */
    public function findByGroupAndStatus($teamId,$statusId){

        $stmt = $this->connection->prepare("SELECT * FROM FRICTIONS WHERE team_id=:teamId AND status_id=:statusId");
        $stmt->execute(["teamId"=>$teamId,"statusId"=>$statusId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    /** getLastIdByAuthor()
     * Query the database to retrieve the most recently created friction id for a given author.
     * 
     * @param {int} $author_id : Id of the friction's author (team member id)
     * @return array|false Associative array containing the friction id in case of success, false if not found
     */
    public function getLastIdByAuthor($author_id){

        $stmt = $this->connection->prepare("SELECT id FROM FRICTIONS WHERE author_id=:author_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute(["author_id"=>$author_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    /** getByIdWithStatus()
     * Query the database to retrieve a friction along with its status label for a given id.
     * 
     * @param {int} $frictionId : Id of the friction to retrieve
     * @return array|false Associative array of friction and status data in case of success, false if not found
     */
    public function getByIdWithStatus($frictionId){

        $stmt = $this->connection->prepare("SELECT f.*,fs.id as status_id,fs.label as status_label FROM FRICTIONS AS f JOIN FRICTION_STATUS AS fs ON f.status_id = fs.id WHERE f.id = :frictionId");
        $stmt->execute(["frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    /** getAuthorUsername()
     * Query the database to retrieve the username of the author of a given friction
     * by joining frictions, team members & users tables.
     * 
     * @param {int} $frictionId : Id of the friction to retrieve the author for
     * @return string|false Author's username in case of success, false if not found
     */
    public function getAuthorUsername($frictionId){

        $stmt = $this->connection->prepare("SELECT u.username FROM FRICTIONS AS f JOIN TEAM_MEMBERS AS tm ON f.author_id=tm.id JOIN USERS AS u ON tm.user_id=u.id WHERE f.id=:frictionId");
        $stmt->execute([":frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** findByPilotAndCycle()
     * Query the database to retrieve all frictions piloted by a given member during a given cycle.
     * 
     * @param {int} $memberId : Id of the team member acting as pilot
     * @param {int} $cycleId : Id of the cycle to filter by
     * @return array Array of matching frictions as associative arrays, empty array if none found
     */
    public function findByPilotAndCycle($memberId,$cycleId){

        $stmt = $this->connection->prepare("SELECT f.* FROM FRICTIONS AS f JOIN TREATMENTS AS t ON f.id=t.friction_id WHERE t.pilot_id = :memberId AND t.cycle_id=:cycleId");
        $stmt->execute([":memberId"=>$memberId,":cycleId"=>$cycleId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    /** findByTeam()
     * Query the database to retrieve all frictions for a given team, enriched with their status label,
     * ordered by creation date descending.
     * 
     * @param {int} $teamId : Id of the team to retrieve frictions for
     * @return array Array of frictions as associative arrays, empty array if none found
     */
    public function findByTeam($teamId) {
        $stmt = $this->connection->prepare(
            "SELECT f.*, fs.label AS status_label 
            FROM FRICTIONS AS f
            JOIN FRICTION_STATUS AS fs ON f.status_id = fs.id
            WHERE f.team_id = :teamId
            ORDER BY f.created_at DESC
        ");
        $stmt->bindValue(":teamId", $teamId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** findByTeamPaginated()
     * Query the database to retrieve a paginated list of frictions for a given team,
     * enriched with their status label, ordered by creation date descending.
     * 
     * @param {int} $teamId : Id of the team to retrieve frictions for
     * @param {int} $limit : Maximum number of results to return
     * @param {int} $offset : Number of results to skip
     * @return array Array of frictions as associative arrays, empty array if none found
     */
    public function findByTeamPaginated($teamId, $limit, $offset) {
        $stmt = $this->connection->prepare(
            "SELECT f.*, fs.label AS status_label 
            FROM FRICTIONS AS f
            JOIN FRICTION_STATUS AS fs ON f.status_id = fs.id
            WHERE f.team_id = :teamId
            ORDER BY f.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(":teamId", $teamId, PDO::PARAM_INT);
        $stmt->bindValue(":limit",  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** countByTeam()
     * Query the database to count the total number of frictions for a given team.
     * 
     * @param {int} $teamId : Id of the team to count frictions for
     * @return int Total number of frictions
     */
    public function countByTeam($teamId) {
        $stmt = $this->connection->prepare("
            SELECT COUNT(*) FROM FRICTIONS WHERE team_id = :teamId
        ");
        $stmt->execute(["teamId" => $teamId]);
        return (int) $stmt->fetchColumn();
    }



}

?>