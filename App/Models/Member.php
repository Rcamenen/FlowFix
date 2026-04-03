<?php
namespace App\Models;
use Core\BaseModel;
use DateTimeImmutable;
use PDO;
use PDOException;

class Member extends BaseModel{

    /** getMember()
     * Ask the DB to retrieve a member of a group by his userId & groupId.
     * 
     * @param {int} $userId : Id of the current user
     * @param {int} $groupId : Id of the targeted group
     * @return array|false Array which represent the member in case of success, false if not
     */

    public function getMember(int $userId, int $groupId): array | false {

        try{
            
            $stmt = $this->connection->prepare("SELECT * FROM TEAM_MEMBERS AS m JOIN TEAMS AS g ON m.team_id = g.id WHERE g.id = :team_id AND m.user_id = :user_id");
            $stmt->execute([":team_id"=>$groupId,":user_id"=>$userId]);

            $result = $stmt->fetch(PDO::FETCH_BOTH);

            return $result;

        }catch (PDOException $e) {
            
            echo $e->getMessage();
            return false;

        }

    }

}

?>