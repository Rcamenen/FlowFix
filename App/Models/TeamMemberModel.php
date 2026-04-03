<?php
namespace App\Models;
use Core\BaseModel;
use PDO;

class TeamMemberModel extends BaseModel{

    public function __construct(){

        $this->tableName = "TEAM_MEMBERS";
        parent::__construct();

    }

    function isTeamMember($userId,$teamId):bool{

        $stmt = $this->connection->prepare("SELECT count(*) FROM TEAM_MEMBERS WHERE user_id=:userId AND team_id=:teamId");

        $stmt->execute([":userId"=>$userId,":teamId"=>$teamId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        
        echo "<br> member_id : <br>";
        var_dump($result);
        echo "<br>";

        return (!empty($result)) ? true : false;

    }

    /** getMember()
     * Ask the DB to retrieve a member of a group by his userId & groupId.
     * 
     * @param {int} $userId : Id of the current user
     * @param {int} $groupId : Id of the targeted group
     * @return array|false Array which represent the member in case of success, false if not
     */

    public function getMemberId(int $userId, int $groupId): int | false {

        $stmt = $this->connection->prepare("SELECT tm.id FROM TEAM_MEMBERS AS tm JOIN TEAMS AS t ON tm.team_id = t.id WHERE t.id = :team_id AND tm.user_id = :user_id");
        $stmt->execute([":team_id"=>$groupId,":user_id"=>$userId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    public function getTeamsByUser($userId){

        $stmt = $this->connection->prepare("SELECT team_id FROM TEAM_MEMBERS WHERE user_id = :user_id");
        $stmt->execute([":user_id"=>$userId]);

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;

    }



}

?>