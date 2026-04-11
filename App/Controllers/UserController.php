<?php
namespace App\Controllers;

use Core\BaseController;

use Exception;
use PDOException;
use App\Services\UserService;

class UserController extends BaseController{

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    /** showGroupsPanel()
     * Check if the user is connected and retrieve their groups and invitations data from the service
     * Call the appropriate view to render the teams panel
     * @param {*}
     * @return void
     */
    public function showGroupsPanel(){

        try{
            $userId = $_SESSION["userId"] ?? null;

            if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");

            $data = $this->userService->showGroupsPanel($userId); // userGroups / userInvitations /

            if(!empty($_GET["connected"])) $data["successMessage"] = "Connexion réussie";

            $this->renderView("teamsPanel",$data);

            exit();

        }catch(PDOException $e){

            echo $e->getMessage();
            // $data["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            // $this->renderView("groupsPanel",$data);

        }catch(Exception $e){
            
            echo $e->getMessage();
            // $data["accessRightsError"] = $e->getMessage();
            // header("Location: \home");

        }


    }

    /** showProfil()
     * Check if the user is connected and retrieve his information from the service
     * Call the appropriate view to render the profil
     * @param {*}
     * @return void
     */
    public function showAccount(){

    try{

        $userId = $_SESSION["userId"] ?? null;

        if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");

        $data = $this->userService->getAccountData($userId);

        $this->renderView("Profil/profil",$data);

    }catch(PDOException $e){

        echo $e->getMessage();
        // $data["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
        // $this->renderView("groupsPanel",$data);

    }catch(Exception $e){
            
        echo $e->getMessage();
        // $data["accessRightsError"] = $e->getMessage();
        // header("Location: \home");

        }

    }
}

?>