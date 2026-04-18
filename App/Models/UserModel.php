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
     * Query the database to retrieve the id and password hash for a given email.
     * 
     * @param {string} $email : Email of the user to look up
     * @return array|false Associative array containing id and password hash in case of success, false if not found
     */
    public function getIdAndHash($email): array | false{

        $stmt = $this->connection->prepare("SELECT id,password_hash FROM ". $this->tableName ." WHERE email=:email");
        $stmt->execute([":email"=>$email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    
    /** isEmailExists()
     * Query the database to check if a given email address already exists in the users table.
     * 
     * @param {string} $email : Email address to check
     * @return bool True if the email exists, false otherwise
     */
    public function isEmailExists(string $email): bool {

        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM ". $this->tableName ." WHERE email=:email");
        $stmt->execute([":email"=>$email]);

        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        
        return ($result>0) ? true : false;
        
    }

    /** createUser()
     * Insert a new user record into the users table.
     * 
     * @param {Array} $userData : Array which contain the user's data to insert
     * @return bool True in case of success, false otherwise
     */
    public function createUser(array $userData): bool {

        $stmt = $this->connection->prepare("INSERT INTO USERS(registered_at,email,firstname,lastname,username,password_hash) values(:registered_at,:email,:firstname,:lastname,:username,:password_hash)");
        $result = $stmt->execute($userData);

        return $result ?? false;

    }

}

?>