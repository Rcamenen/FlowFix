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
     * Return true if the friction is owned by the team, false otherwise
     * @param int $author
     * @param int $teamId
     * @return bool
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
     * Query the database to retrieve all frictions matching a given team and status
     * Return the results as an array of associative arrays
     * @param int $teamId
     * @param int $statusId
     * @return array
     */
    public function findByGroupAndStatus($teamId,$statusId){

        $stmt = $this->connection->prepare("SELECT * FROM FRICTIONS WHERE team_id=:teamId AND status_id=:statusId");
        $stmt->execute(["teamId"=>$teamId,"statusId"=>$statusId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    /** getLastIdByAuthor()
     * Query the database to retrieve the most recently created friction ID for a given author
     * Return the result as an associative array or false if not found
     * @param int $author_id
     * @return array|false
     */
    public function getLastIdByAuthor($author_id){

        $stmt = $this->connection->prepare("SELECT id FROM FRICTIONS WHERE author_id=:author_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute(["author_id"=>$author_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    /** getByIdWithStatus()
     * Query the database to retrieve a friction along with its status details matching the given ID
     * Return the result as an associative array or false if not found
     * @param int $frictionId
     * @return array
     */
    public function getByIdWithStatus($frictionId){

        $stmt = $this->connection->prepare("SELECT f.*,fs.id as status_id,fs.label as status_label FROM FRICTIONS AS f JOIN FRICTION_STATUS AS fs ON f.status_id = fs.id WHERE f.id = :frictionId");
        $stmt->execute(["frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    /** getAuthorUsername()
     * Query the database to retrieve the username of the author of a given friction
     * Return the username as a string or false if not found
     * @param int $frictionId
     * @return string|false
     */
    public function getAuthorUsername($frictionId){

        $stmt = $this->connection->prepare("SELECT u.username FROM FRICTIONS AS f JOIN TEAM_MEMBERS AS tm ON f.author_id=tm.id JOIN USERS AS u ON tm.user_id=u.id WHERE f.id=:frictionId");
        $stmt->execute([":frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    public function findByPilotAndCycle($memberId,$cycleId){

        $stmt = $this->connection->prepare("SELECT f.* FROM FRICTIONS AS f JOIN TREATMENTS AS t ON f.id=t.friction_id WHERE t.pilot_id = :memberId AND t.cycle_id=:cycleId");
        $stmt->execute([":memberId"=>$memberId,":cycleId"=>$cycleId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public function findInProgress($teamId){

        $stmt = $this->connection->prepare("
            SELECT 
                f.id AS f_id,
                f.title AS title,
                f.description AS description,
                f.created_at AS created_at,
                f.status_id AS status_id,
                fs.label AS status_label
            FROM FRICTIONS AS f 
            JOIN FRICTION_STATUS AS fs ON f.status_id = fs.id 
            WHERE f.team_id = :teamId AND fs.id=:status
        ");

        $stmt->execute(["teamId" => $teamId,"status" => 2]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }


    public function createFriction($created_at, $title, $description, $updated_at, $author_id, $team_id, $status_id, $id = null): bool {

        $stmt = $this->connection->prepare("
            INSERT INTO FRICTIONS(created_at, title, description, updated_at, author_id, team_id, status_id) 
            VALUES(:created_at, :title, :description, :updated_at, :author_id, :team_id, :status_id)
        ");

        $result = $stmt->execute([
            "created_at"  => $created_at,
            "title"       => $title,
            "description" => $description,
            "updated_at"  => $updated_at,
            "author_id"   => $author_id,
            "team_id"     => $team_id,
            "status_id"   => $status_id
        ]);

        return $result ?? false;

    }

    ///////////////////////////// TEST /////////////////////////////////

    public function findByTeamPaginated($teamId, $limit, $offset) {
        $stmt = $this->connection->prepare("
            SELECT f.*, fs.label AS status_label 
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

    public function countByTeam($teamId) {
        $stmt = $this->connection->prepare("
            SELECT COUNT(*) FROM FRICTIONS WHERE team_id = :teamId
        ");
        $stmt->execute(["teamId" => $teamId]);
        return (int) $stmt->fetchColumn();
    }



}

?>