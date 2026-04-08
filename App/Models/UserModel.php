<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class UserModel extends BaseModel{

    protected string $idField = "id";
    protected string $emailField = "email";

    public function __construct(){

        $this->tableName = "USERS";
        parent::__construct();

    }

    /** getIdAndHash()  
     * Query the database to retrieve the user ID and password hash matching the given email
     * Return the result as an associative array or false if not found
     * @param string $email
     * @return array|false
     */
    public function getIdAndHash($email): array | false{

        $stmt = $this->connection->prepare("SELECT id,password_hash FROM ". $this->tableName ." WHERE email=:email");
        $stmt->execute([":email"=>$email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    
    /** isEmailExist($email)
     * Check if an email exist in the table
     * 
     * @param {string} $email
     * @return bool
     */
    
    public function isEmailExists(string $email): bool {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM ". $this->tableName ." WHERE email=:email");
        $stmt->execute([":email"=>$email]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        
        return ($result>0) ? true : false;
        
    }

    /** createUser()
     * Add user in DB's user table
     * 
     * @param {UserEntity} $userEntity : Objet représentant un user
     * @return bool true in case of success, false if not
     */

    public function createUser(array $userData): bool {

        $stmt = $this->connection->prepare("INSERT INTO USERS(registered_at,email,firstname,lastname,username,password_hash) values(:registered_at,:email,:firstname,:lastname,:username,:password_hash)");
        $result = $stmt->execute($userData);

        return $result ?? false;

    }

    public function deleteUser(int $userId): bool {

        $stmt = $this->connection->prepare("DELETE FROM USERS WHERE id = :id");
        $result = $stmt->execute(["id" => $userId]);

        return $result ?? false;

    }

}

?>