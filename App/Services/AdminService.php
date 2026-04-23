<?php
namespace App\Services;

use App\Models\AdminModel;
use App\Models\UserModel;
use App\Models\TeamModel;
use App\Models\TeamMemberModel;

use Exception;
use App\Exceptions\FormException;
use App\Exceptions\RoleException;

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


    /** showAdminPanel()
     * Render the admin panel view.
     * 
     * @param void
     * @return void Render admin panel view
     */
    public function showAdminPanel(){

        echo "adminController->showAdminPanel()";

    }

    /** connectAdmin()
     * Validate credentials, verify email/password match & return formatted session data on success.
     * 
     * @param {Array} $connectAdminData : Array which contain admin's login credentials
     * @return array|false Array of session data in case of success, throw exception if not
     */
    public function connectAdmin($connectAdminData){

        echo "<br> AdminService -> connectAdmin() <br>";

        // ================== CHECKING DATA =================== //

        $errors = $this->connectAdminDataCheck($connectAdminData);

        if($errors) throw new FormException($errors,"adminLogin","Couple email / mot de passe incorrecte");

        // ================== MATCHING EMAIL/PASSWORD =================== //

        // $adminIdAndHash = $this->adminModel->getIdAndHash($connectAdminData["email"]);


        $adminIdAndHash = $this->adminModel->findBy(["password_hash","id"],["email"=>$connectAdminData["email"]],"oneassoc");

        if(!$adminIdAndHash) throw new RoleException("adminLogin","Couple nom d'utilisateur / mot de passse incorrecte");

        $passwordMatch = password_verify($connectAdminData["password"],$adminIdAndHash["password_hash"]);
        
        if(!$passwordMatch) throw new Exception("Couple nom d'utilisateur / mot de passse incorrecte");

        // ================== DATA FORMATING FOR CONTROLLER =================== //

        $response=[
            "adminId" =>$adminIdAndHash["id"]
        ];

        return $response;

    }

    /** connectAdminDataCheck()
     * Validate connection form data by checking if all required fields are filled.
     * 
     * @param {Array} $connectAdminData : Array which contain admin's login credentials
     * @return array|false Array of errors if any field is missing, false otherwise
     */
    public function connectAdminDataCheck($connectAdminData){

        // Checking if each field is filled
        foreach($connectAdminData as $data => $value){
            if(empty($value)) $errors[$data]= "Le champs $data est manquant !";
        }

        return $errors ?? false;

    }

    /** getUsersPage()
     * Retrieve a paginated list of users & format pagination data for the view.
     * 
     * @param {int} $page : Current page number
     * @return array Array containing users list, current page & total pages
     */
    public function getUsersPage(int $page): array
    {
        $limit  = 10;
        $offset = ($page - 1) * $limit;
 
        $users      = $this->userModel->findAllPaginated($limit, $offset);
        $totalCount = $this->userModel->countAll();
        $totalPages = (int) ceil($totalCount / $limit);
 
        return [
            "users"      => $users,
            "currentPage"       => $page,
            "totalPages" => $totalPages,
        ];
    }
 
 
    /** getTeamsPage()
     * Retrieve a paginated list of teams & format pagination data for the view.
     * 
     * @param {int} $page : Current page number
     * @return array Array containing teams list, current page & total pages
     */
    public function getTeamsPage(int $page): array
    {
        $limit  = 10;
        $offset = ($page - 1) * $limit;
 
        $teams      = $this->teamModel->findAllPaginated($limit, $offset);
        $totalCount = $this->teamModel->countAll();
        $totalPages = (int) ceil($totalCount / $limit);

        //formatage pour la vue
        foreach($teams as $team => $value){
            $teams[$team]["created_at"] = (new DateTime($team['created_at']))->format('d-m-Y');
        }
 
        return [
            "teams" => $teams,
            "currentPage" => $page,
            "totalPages" => $totalPages,
        ];
    }
}

?>