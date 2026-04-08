<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class TeamModel extends BaseModel{

    public function __construct(){

        $this->tableName = "TEAMS";
        parent::__construct();

    }

    /** getTeamsByUser()
     * Query the database to retrieve all teams associated with a given user
     * Return the results as an array of associative arrays or false if none found
     * @param int $userId
     * @return array|false
     */
    public function getTeamsByUser($userId) :Array | bool {

        $stmt = $this->connection->prepare("SELECT t.* FROM TEAMS as t JOIN TEAM_MEMBERS as tm ON (t.id = tm.team_id) WHERE tm.user_id=:userId");
        $stmt->execute([":userId"=>$userId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ?? false;

    }

}

?>