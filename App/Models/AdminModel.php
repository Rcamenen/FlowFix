<?php
namespace App\Models;

use Core\BaseModel;

use PDO;

class AdminModel extends BaseModel{

    protected string $idField = "id";
    protected string $emailField = "email";

    public function __construct(){

        $this->tableName = "ADMINS";
        parent::__construct();

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

}

?>