<?php
namespace App\Models;
use Core\BaseModel;
use PDO;
use PDOException;
use App\Entities\GroupEntity;
use DateTimeImmutable;

class Group extends BaseModel{

    public function getGroupsByIds(array $ids){

        $placeholders = implode(",",array_fill(0,count($ids),"?"));

        try{
            
            $stmt = $this->connection->prepare("SELECT * FROM TEAMS WHERE team_id IN ($placeholders)");
            $stmt->execute($ids);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;

        }catch (PDOException $e) {
            echo $e->getMessage();
            throw new PDOException("Problème avec la base de données");
            return false;

        }

    }
    
    public function getGroupsByUser($userId) :Array | bool {
        try{

            $stmt = $this->connection->prepare("SELECT g.* FROM TEAMS as g JOIN TEAM_MEMBERS as m USING (team_id) WHERE m.user_id=:userId");
            $stmt->execute([":userId"=>$userId]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            var_dump($result);

            $groups = [];

            if($result){
                foreach($result as $group){
                    $groupEntity = new GroupEntity(
                        new DateTimeImmutable($group["created_at"]),
                        $group["name"],
                        $group["description"],
                        $group["creator_id"],
                        $group["team_id"]
                    );

                    $groups[]=$groupEntity;

                }
            }

            return $groups ?? false;

        }catch(PDOException $e){
            echo $e->getMessage();
            throw new PDOException("Problème avec la base de données");
            return false;
        }

    }

}

?>