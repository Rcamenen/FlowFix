<?php
namespace App\Models;
use Core\BaseModel;
use App\Entities\UserEntity;
use PDOException;

class User extends BaseModel{

    /** getUserByEmail($email)
     * Returns user's table field which match with the $email parameter
     * 
     * @param {string} $email
     * @return array|false
     */
    public function getUserByEmail(string $email): array|false {

        try{
            
            $stmt = $this->connection->prepare("SELECT * FROM USER_ WHERE email=:email");
            $stmt->execute([":email"=>$email]);

            $result = $stmt->fetch();

            return $result;

        }catch (PDOException $e) {

            echo "User.php Error";
            throw new PDOException("Problème avec la base de données");
            return false;

        }

    }

    /** addUser()
     * Add user in DB's user table
     * 
     * @param {UserEntity} $userEntity : Objet représentant un user
     * @return bool true in case of success, false if not
     */

    public function addUser(UserEntity $userEntity): bool {

        try{
            
            $stmt = $this->connection->prepare("INSERT INTO USER_(registered_at,email,firstname,lastname,username,password) values(:registered_at,:email,:firstname,:lastname,:username,:password)");
            $result = $stmt->execute(
                [":registered_at"=>$userEntity->getRegisterDate()->format("Y-m-d h:i:s"),
                ":email"=>$userEntity->getEmail(),
                ":firstname"=>$userEntity->getFirstname(),
                ":lastname"=>$userEntity->getLastname(),
                ":username"=>$userEntity->getUsername(),
                ":password"=>$userEntity->getHash()
                ]);

            return $result;

        }catch (PDOException $e) {

            echo $e->getMessage();
            throw new PDOException("Problème avec la base de données");
            return false;

        }

    }

}

?>