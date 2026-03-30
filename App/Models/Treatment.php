<?php
namespace App\Models;
use Core\BaseModel;
use PDO;
use PDOException;

class Treatment extends BaseModel{
    
    function findByMember($member_id){

        $stmt = $this->connection->prepare("SELECT t.* FROM TREATMENTS AS t JOIN CYCLES AS c ON t.cycle_id=c.cycle_id WHERE t.member_id=:member_id ORDER BY c.start_date DESC");
        $stmt->execute([":member_id"=>$member_id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<br> TRAITEMENT : <br>";
        var_dump($result);

        return $result;

    }

}

?>