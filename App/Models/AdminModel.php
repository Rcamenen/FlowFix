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

}

?>