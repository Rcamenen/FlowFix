<?php
namespace App\Services;

use App\Models\AdminModel;
use App\Models\UserModel;
use App\Models\TeamModel;
use App\Models\TeamMemberModel;

use Exception;
use App\Exceptions\FormException;

use DateTime;

class AdminService{

    private AdminModel $adminModel;
    private UserModel $userModel;
    private TeamModel $teamModel;

    public function __construct(){

        $this->adminModel = new AdminModel();
        $this->userModel = new UserModel();
        $this->teamModel = new TeamModel();

    }

    public function showAdminPanel(){

        echo "adminController->showAdminPanel()";

    }

    public function showUsers(){

        $response["users"]=$this->userModel->getAll();

        return $response;

    }

    public function showTeams(){

        $response["teams"]=$this->teamModel->getAll();

        return $response;

    }

    public function connectAdmin($connectAdminData){

        echo "<br> AdminService -> connectAdmin() <br>";

        // ================== CHECKING DATA =================== //

        $errors = $this->connectAdminDataCheck($connectAdminData);

        if($errors) throw new FormException($errors,"login","Champs login incorrects");

        // ================== MATCHING EMAIL/PASSWORD =================== //

        // $adminIdAndHash = $this->adminModel->getIdAndHash($connectAdminData["email"]);
        $adminIdAndHash = $this->adminModel->findBy(["password_hash","id"],["email"=>$connectAdminData["email"]],"oneassoc");
        echo "<br> adminIdAndHash <br>";

        var_dump($adminIdAndHash);

        if(!$adminIdAndHash) throw new Exception("Couple nom d'utilisateur / mot de passse incorrecte");

        $passwordMatch = password_verify($connectAdminData["password"],$adminIdAndHash["password_hash"]);
        
        if(!$passwordMatch) throw new Exception("Couple nom d'utilisateur / mot de passse incorrecte");

        // ================== DATA FORMATING FOR CONTROLLER =================== //

        $response=[
            "adminId" =>$adminIdAndHash["id"]
        ];

        return $response;

    }

    /** connectAdminDataCheck()
     * Validate the connection form data by checking if all required fields are filled
     * Return an array of errors if any field is missing
     * @param array $connectUserData
     * @return array
     */
    public function connectAdminDataCheck($connectAdminData){

        // Checking if each field is filled
        foreach($connectAdminData as $data => $value){
            if(empty($value)) $errors[$data]= "Le champs $data est manquant !";
        }

        return $errors ?? false;

    }
}

?>