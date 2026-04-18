<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class TeamMemberModel extends BaseModel{

    public function __construct(){

        $this->tableName = "TEAM_MEMBERS";
        parent::__construct();

    }


    /** findMemberId()
     * Query the database to retrieve the team member id matching a given user id and team id.
     * 
     * @param {int} $userId : Id of the user to look up
     * @param {int} $teamId : Id of the team to filter by
     * @return int|false Team member id in case of success, false if not found
     */
    public function findMemberId(int $userId, int $teamId): int | false {

        $stmt = $this->connection->prepare("SELECT tm.id FROM TEAM_MEMBERS AS tm JOIN TEAMS AS t ON tm.team_id = t.id WHERE t.id = :team_id AND tm.user_id = :user_id");
        $stmt->execute([":team_id"=>$teamId,":user_id"=>$userId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** getTeamsByUser()
     * Query the database to retrieve all team ids associated with a given user.
     * 
     * @param {int} $userId : Id of the user to retrieve teams for
     * @return array Array of team ids, empty array if none found
     */
    public function getTeamsByUser($userId){

        $stmt = $this->connection->prepare("SELECT team_id FROM TEAM_MEMBERS WHERE user_id = :user_id");
        $stmt->execute([":user_id"=>$userId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }

    /** findModerateTeamByUser()
     * Query the database to retrieve all team ids for which a given user has a moderator role.
     * 
     * @param {int} $userId : Id of the user to retrieve moderated teams for
     * @return array Array of team ids, empty array if none found
     */
    public function findModerateTeamByUser(int $userId):array{

        $stmt = $this->connection->prepare("SELECT team_id FROM TEAM_MEMBERS WHERE user_id = :user_id AND promoted_at IS NOT NULL");
        $stmt->execute([":user_id"=>$userId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }

    /** getRandomMemberNotPilot()
     * Query the database to retrieve a random team member who is not already assigned
     * as a pilot during the given cycle.
     * 
     * @param {int} $teamId : Id of the team to pick a member from
     * @param {int} $cycleId : Id of the cycle to check pilot assignments against
     * @return int|false Id of the selected member in case of success, false if none available
     */
    public function getRandomMemberNotPilot($teamId, $cycleId) {

        $stmt = $this->connection->prepare("SELECT tm.id FROM TEAM_MEMBERS AS tm WHERE tm.team_id = :teamId AND tm.id NOT IN (SELECT pilot_id FROM TREATMENTS WHERE cycle_id = :cycleId) ORDER BY RAND() LIMIT 1");

        $stmt->bindValue(":teamId", $teamId, PDO::PARAM_INT);
        $stmt->bindValue(":cycleId", $cycleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);

    }

    /** findMembersByTeam()
     * Query the database to retrieve all members of a given team with their username,
     * join date & moderator role, ordered by join date ascending.
     * 
     * @param {int} $teamId : Id of the team to retrieve members for
     * @return array Array of members as associative arrays, empty array if none found
     */
    public function findMembersByTeam($teamId){

        $stmt = $this->connection->prepare("
            SELECT tm.id, tm.joined_at, tm.promoted_at, u.username
            FROM " . $this->tableName . " tm
            JOIN users u ON u.id = tm.user_id
            WHERE tm.team_id = :teamId
            ORDER BY tm.joined_at ASC
        ");

        $stmt->execute([":teamId" => $teamId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}

?>