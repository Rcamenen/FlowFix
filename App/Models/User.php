<?php
namespace App\Models;
use Core\BaseModel;
use App\Entities\UserEntity;
use DateTimeImmutable;
use PDO;
use PDOException;

class User extends BaseModel{

    protected string $tableName = "USERS";
    protected string $idField = "user_id";
    protected string $emailField = "email";

    /** isEmailExist($email)
     * Check if an email exist in the table
     * 
     * @param {string} $email
     * @return bool
     */
    
    public function isEmailExists(string $email): bool {

        try{
            
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM ". $this->tableName ." WHERE email=:email");
            $stmt->execute([":email"=>$email]);

            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            
            return ($result>0) ? true : false;

        }catch (PDOException $e) {

            throw new PDOException("Problème avec la base de données");
            return false;

        }
    }

    /** getUserByEmail($email)
     * Returns user's table field which match with the $email parameter
     * 
     * @param {string} $email
     * @return UserEntity|false
     */

    public function getUserByEmail(string $email): UserEntity | false {

        try{
            
            $stmt = $this->connection->prepare("SELECT * FROM ". $this->tableName ." WHERE email=:email");
            $stmt->execute([":email"=>$email]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($result){
                $userEntity = new UserEntity(
                    new DateTimeImmutable($result['registered_at']),
                    $result['email'],
                    $result['firstname'],
                    $result['lastname'],
                    $result['username'],
                    $result['password_hash'],
                    $result['user_id']
                );
            }
            
            return $userEntity ?? false;

        }catch (PDOException $e) {

            throw new PDOException("Problème avec la base de données");
            return false;

        }

    }

    /** createUser()
     * Add user in DB's user table
     * 
     * @param {UserEntity} $userEntity : Objet représentant un user
     * @return bool true in case of success, false if not
     */

    public function createUser(UserEntity $userEntity): bool {

        try{
            
            $stmt = $this->connection->prepare("INSERT INTO USERS(registered_at,email,firstname,lastname,username,password_hash) values(:registered_at,:email,:firstname,:lastname,:username,:password)");
            $result = $stmt->execute(
                [":registered_at"=>$userEntity->getRegisterDate()->format("Y-m-d h:i:s"),
                ":email"=>$userEntity->getEmail(),
                ":firstname"=>$userEntity->getFirstname(),
                ":lastname"=>$userEntity->getLastname(),
                ":username"=>$userEntity->getUsername(),
                ":password"=>$userEntity->getPassword()
                ]);

            return $result;

        }catch (PDOException $e) {

            echo $e->getMessage();
            // throw new PDOException("Problème avec la base de données");
            return false;

        }

    }

}

?>