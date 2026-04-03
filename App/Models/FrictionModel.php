<?php
namespace App\Models;
use Core\BaseModel;
// use App\Entities\FrictionEntity;
// use App\Entities\FrictionEntityTest;
use PDO;

class FrictionModel extends BaseModel{

    public function __construct()
    {
        $this->tableName = "FRICTIONS";
        parent::__construct();
    }
    
    public function getByGroupAndStatus($teamId,$statusId){

        $stmt = $this->connection->prepare("SELECT * FROM FRICTIONS WHERE team_id=:teamId AND status_id=:statusId");
        $stmt->execute(["teamId"=>$teamId,"statusId"=>$statusId]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    public function getLastIdByAuthor($author_id){

        $stmt = $this->connection->prepare("SELECT id FROM FRICTIONS WHERE author_id=:author_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute(["author_id"=>$author_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    public function getByIdWithStatus($frictionId){

        $stmt = $this->connection->prepare("SELECT f.*, fs.* FROM FRICTIONS AS f JOIN FRICTION_STATUS AS fs ON f.status_id = fs.id WHERE f.id = :frictionId");
        $stmt->execute(["frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }

    public function getAuthorUsername($frictionId){

        $stmt = $this->connection->prepare("SELECT u.username FROM FRICTIONS AS f JOIN TEAM_MEMBERS AS tm ON f.author_id=tm.id JOIN USERS AS u ON tm.user_id=u.id WHERE f.id=:frictionId");
        $stmt->execute([":frictionId"=>$frictionId]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return $result;

    }

    // public function createFriction($created_at,$title,$description,$updated_at,$author_id,$team_id,$status_id,$id=null){

    //     $this->entity->set($created_at,$title,$description,$updated_at,$author_id,$team_id,$status_id,$id);
    //     return $this->createTestObject($this->entity);

    // }



}

?>