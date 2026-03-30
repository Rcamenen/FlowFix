<?php
namespace App\Controllers;
use App\Services\UserService;
use Core\BaseController;
use Exception;
use PDOException;

class UserController extends BaseController{

    /** createUser()
     * Make the first control on $_POST values and send it to the service to continue the creation process
     * Call the appropriate view in case of success or failed in the process
     * @param {*}
     * @return void
     */

    public function showGroupsPanel(){

        try{

            if($this->isUserConnected()){

                $userService = new UserService();

                $data["userGroups"] = $userService->showGroupsPanel($_SESSION["userId"]); // userGroups / userInvitations /

                if(!empty($_GET["connected"])) $data["successMessage"] = "Connexion réussie";

            }else throw new Exception("Vous devez être connecté pour voir cette page..."); //Faire un AuthException

            $this->renderView("groupsPanel",$data);

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