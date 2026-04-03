<?php
namespace App\Controllers;
use App\Services\UserService;
use Core\BaseController;
use Exception;
use PDOException;

class UserController extends BaseController{

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    /** createUser()
     * Make the first control on $_POST values and send it to the service to continue the creation process
     * Call the appropriate view in case of success or failed in the process
     * @param {*}
     * @return void
     */

    public function showGroupsPanel(){
        echo "<br> UserController -> ShowGroupsPanel() <br>";

        try{
            $userId = $_SESSION["userId"];    
            $userTeamsId = $_SESSION["teamsId"];

            if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");

            $data = $this->userService->showGroupsPanel($userId); // userGroups / userInvitations /

            if(!empty($_GET["connected"])) $data["successMessage"] = "Connexion réussie";

            $this->renderView("teamsPanel",$data);

        }catch(PDOException $e){

            $e->getMessage();
            // $data["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            // $this->renderView("groupsPanel",$data);

        }catch(Exception $e){
            
            $e->getMessage();
            // $data["accessRightsError"] = $e->getMessage();
            // header("Location: \home");

        }
        


    }

    //public function profil(){...}
}

?>