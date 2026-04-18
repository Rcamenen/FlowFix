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
     * Query the database to retrieve all teams associated with a given user,
     * enriched with their full team data by joining the teams table.
     * 
     * @param {int} $userId : Id of the user to retrieve teams for
     * @return array|false Array of teams as associative arrays in case of success, false if none found
     */
    public function getTeamsByUser($userId) :Array | bool {

        $stmt = $this->connection->prepare("SELECT t.* FROM TEAMS as t JOIN TEAM_MEMBERS as tm ON (t.id = tm.team_id) WHERE tm.user_id=:userId");
        $stmt->execute([":userId"=>$userId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ?? false;

    }

}

?>