<?php
namespace App\Services;

use App\Models\UserModel;
use App\Models\TeamModel;
use App\Models\TeamMemberModel;
use App\Models\FrictionModel;
use App\Models\TreatmentModel;

use Exception;
use App\Exceptions\FormException;
use App\Exceptions\RoleException;

use DateTime;

class UserService{

    private UserModel $userModel;
    private TeamModel $teamModel;
    private TeamMemberModel $teamMemberModel;
    private FrictionModel $frictionModel;
    private TreatmentModel $treatmentModel;

    public function __construct(){

        $this->userModel = new UserModel();
        $this->teamModel = new TeamModel();
        $this->teamMemberModel = new TeamMemberModel();
        $this->frictionModel = new FrictionModel();
        $this->treatmentModel = new TreatmentModel();

    }

    /** connectUserDataCheck()
     * Validate the connection form data by checking if all required fields are filled
     * Return an array of errors if any field is missing
     * @param array $connectUserData
     * @return array
     */
    public function connectUserDataCheck($connectUserData){

        // Checking if each field is filled
        foreach($connectUserData as $data => $value){
            if(empty($value)) $errors[$data]= "Le champs $data est manquant !";
        }

        return $errors ?? false;

    }

    /** createUserDataCheck()
     * Validate the registration form data by checking required fields, email format, email uniqueness and password length
     * Return an array of errors if any validation fails, false otherwise
     * @param array $createUserData
     * @return array|false
     */
    public function createUserDataCheck($createUserData):array|false{

        // Checking if each field is filled
        foreach($createUserData as $data => $value){
            if(empty($value)) $errors[$data]= "Le champs $data est manquant !";
        }

        // Checking the email

        if(!filter_var($createUserData["email"],FILTER_VALIDATE_EMAIL)){
            $errors["email"]= "L'email est au mauvais format";
        }

        if($this->userModel->isEmailExists($createUserData["email"])){
            $errors["email"]="L'email saisi existe déjà !";
        }

        // Checking of the password

        if(strlen($createUserData["password"]) < 8){
            $errors["password"]="Le mot de passe doit contenir au moins 8 caractères";
        }

        return $errors ?? false;

    }

    /** createUser()
     * Apply business verification & ask the model to add the user in the DB's user table.
     * 
     * @param {UserEntity} $userEntity : Object which represent user
     * @return bool true in case of success, false if not
     */

    public function createUser($createUserData){

        // ==================DATA CHECKING=================== //

        $errors = $this->createUserDataCheck($createUserData);

        if(!empty($errors)) throw new FormException($errors,"register","Champs incorrectes");
        

        // ================== USER CREATION =================== //

        $userData=[
            "registered_at"=>new DateTime()->format("Y-m-d H:i:s"),
            "email"=>$createUserData["email"],
            "firstname"=>$createUserData["firstname"],
            "lastname"=>$createUserData["lastname"],
            "username"=>$createUserData["username"],
            "password_hash"=>password_hash($createUserData["password"],PASSWORD_DEFAULT)
        ];

        $this->userModel->createUser($userData);

    }

    /** connectUser()
     * Apply business verification & ask the model to connect the user with his credentials.
     * 
     * @param {Array} $connectUserData : Array which contain user's login informations
     * @return int user's id in case of success, throw exception if not
     */
    public function connectUser($connectUserData) :array | false {

        // ================== CHECKING DATA =================== //

        $errors = $this->connectUserDataCheck($connectUserData);

        if($errors) throw new FormException($errors,"login","Champs login incorrects");


        // ================== MATCHING EMAIL/PASSWORD =================== //

        $userIdAndHash = $this->userModel->getIdAndHash($connectUserData["email"]);

        if(!$userIdAndHash) throw new RoleException("login","Couple nom d'utilisateur / mot de passse incorrecte");

        $passwordMatch = password_verify($connectUserData["password"],$userIdAndHash["password_hash"]);
        
        if(!$passwordMatch) throw new RoleException("login","Couple nom d'utilisateur / mot de passse incorrecte");

        // ================== LOOKING FOR TEAMS THE USER IS MEMBER OF =================== //

        $teamsId = $this->teamMemberModel->getTeamsByUser($userIdAndHash["id"]);

        // ================== LOOKING FOR TEAMS THE USER IS MODERATOR OF =================== //

        $moderateTeamsId = $this->teamMemberModel->findModerateTeamByUser($userIdAndHash["id"]);

        // ================== DATA FORMATING FOR CONTROLLER =================== //

        $response=[
            "teamsId" => $teamsId,
            "moderateTeamsId" => $moderateTeamsId,
            "userId" =>$userIdAndHash["id"]
        ];

        return $response;

    }

    /** showGroupsPanel()
     * Retrieve all groups linked to a user & format them for the view.
     * 
     * @param {int} $userId : Id of the current user
     * @return array|false Array of user's groups in case of success, false if not
     */
    public function showGroupsPanel($userId) :array|false {

        $userTeams = $this->teamModel->getTeamsByUser($userId);

        foreach($userTeams as $userTeam){

            $userTeamData = [
                "id"=>$userTeam["id"],
                "name"=>$userTeam["name"],
                "description"=>$userTeam["description"]
            ];

            $userTeamsData[]=$userTeamData;
            
        }

        $response=["userTeams"=>$userTeamsData ?? null]; // ?? null si le user n'a aucune team

        return $response ?? false;

    }

    /** getProfilData()
     * Retrieve the user information by using his userId.
     * 
     * @param {int} $userId : Id of the current user
     * @return array|false Array of user's data in case of success, false if not
     */
    public function getAccountData($userId){

        $user = $this->userModel->getById($userId);

        $response["user"] = $user;

        return $response;

    }

    public function delete($userId){

        //Récupérer groupes et memberID
        $userMembersId = $this->teamMemberModel->findBy(["id"],["user_id"=>$userId],"column");

        foreach($userMembersId as $memberId){

            $this->teamMemberModel->update($memberId,["user_id"=>0]);

        }

        $this->userModel->delete($userId);

    }

}

?>