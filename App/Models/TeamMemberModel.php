<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class TeamMemberModel extends BaseModel{

    public function __construct(){

        $this->tableName = "TEAM_MEMBERS";
        parent::__construct();

    }

    /** isTeamMember()
     * Query the database to check if a given user is a member of a given team
     * Return true if the user is a member, false otherwise
     * @param int $userId
     * @param int $teamId
     * @return bool
     */
    function isTeamMember($userId,$teamId):bool{

        $stmt = $this->connection->prepare("SELECT count(*) FROM TEAM_MEMBERS WHERE user_id=:userId AND team_id=:teamId");

        $stmt->execute([":userId"=>$userId,":teamId"=>$teamId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        
        return (!empty($result)) ? true : false;

    }


    /** findMemberId()
     * Query the database to retrieve the team member ID matching the given user ID and group ID
     * Return the member ID as an integer or false if not found
     * @param int $userId
     * @param int $groupId
     * @return int|false
     */
    public function findMemberId(int $userId, int $teamId): int | false {

        $stmt = $this->connection->prepare("SELECT tm.id FROM TEAM_MEMBERS AS tm JOIN TEAMS AS t ON tm.team_id = t.id WHERE t.id = :team_id AND tm.user_id = :user_id");
        $stmt->execute([":team_id"=>$teamId,":user_id"=>$userId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    /** getTeamsByUser()
     * Query the database to retrieve all team IDs associated with a given user
     * Return the results as an array of team IDs
     * @param int $userId
     * @return array
     */
    public function getTeamsByUser($userId){

        $stmt = $this->connection->prepare("SELECT team_id FROM TEAM_MEMBERS WHERE user_id = :user_id");
        $stmt->execute([":user_id"=>$userId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }

    public function findModerateTeamByUser(int $userId):array{

        $stmt = $this->connection->prepare("SELECT team_id FROM TEAM_MEMBERS WHERE user_id = :user_id AND promoted_at IS NOT NULL");
        $stmt->execute([":user_id"=>$userId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }

    public function getRandomMemberNotPilot($teamId, $cycleId) {

        $stmt = $this->connection->prepare("SELECT tm.id FROM TEAM_MEMBERS AS tm WHERE tm.team_id = :teamId AND tm.id NOT IN (SELECT pilot_id FROM TREATMENTS WHERE cycle_id = :cycleId) ORDER BY RAND() LIMIT 1");

        $stmt->bindValue(":teamId", $teamId, PDO::PARAM_INT);
        $stmt->bindValue(":cycleId", $cycleId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);

    }

}

?>