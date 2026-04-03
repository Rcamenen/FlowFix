<?php
namespace App\Models;
use Core\BaseModel;
use PDO;
use PDOException;
use App\Entities\TeamEntity;
use DateTimeImmutable;

class TeamModel extends BaseModel{

    public function getGroupsByIds(array $ids){

        $placeholders = implode(",",array_fill(0,count($ids),"?"));

        try{
            
            $stmt = $this->connection->prepare("SELECT * FROM TEAMS WHERE id IN ($placeholders)");
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

            $stmt = $this->connection->prepare("SELECT t.* FROM TEAMS as t JOIN TEAM_MEMBERS as tm ON (t.id = tm.team_id) WHERE tm.user_id=:userId");
            $stmt->execute([":userId"=>$userId]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            var_dump($result);

            return $result ?? false;

        }catch(PDOException $e){
            echo $e->getMessage();
            throw new PDOException("Problème avec la base de données");
            return false;
        }

    }

}

?>