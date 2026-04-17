<?php
namespace App\Controllers;

use App\Exceptions\RoleException;
use Core\BaseController;

use Exception;
use App\Services\UserService;

class UserController extends BaseController{

    private UserService $userService;

    public function __construct(){
        $this->userService = new UserService;
    }

    /** showTeamsPage()
     * Check if the user is connected and retrieve their groups and invitations data from the service
     * Call the appropriate view to render the teams panel
     * @param {*}
     * @return void
     */
    public function showTeamsPage(){

        $userId = $_SESSION["userId"] ?? null;

        if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");

        $data = $this->userService->showGroupsPanel($userId); // userGroups / userInvitations /

        if(!empty($_GET["connected"])) $data["successMessage"] = "Connexion réussie";

        $this->renderView("User/teamsPanel",$data);

        exit();

    }

    /** showAccountPage()
     * Check if the user is connected and retrieve his information from the service
     * Call the appropriate view to render the profil
     * @param {*}
     * @return void
     */
    public function showAccountPage(){

        $userId = $_SESSION["userId"] ?? null;

        if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");

        $data = $this->userService->getAccountData($userId);

        $this->renderView("Profil/profil",$data);

    }


    /** createUser()
     * Get $_POST values and send them to the service to continue the creation process
     * Call the appropriate view in case of success or failed in the process
     * @param {*}
     * @return void
     */
    public function createUser(){

        // ================== RÉCUPÉRATION DES DONNÉES =================== //
        
        $createUserData = $this->getPost(["email","firstname","lastname","username","password"]);


        // ================== APPEL DU SERVICE =================== //

        $this->userService->createUser($createUserData);

        // ================== REDIRECTION VERS LOGIN =================== //

        header('Location: /login?registered=true');
        exit();

    }

    /** deleteUser()
     * 
     * 
     * 
     * @param {array} params[]
     * @return void
     */
    public function deleteUser($params){

        // Check if the request is ask by the user himself or an admin
        if(!$this->checkRole("user")) throw new RoleException("/","Vous devez vous connecter pour effectuer cette action");

        $currentUserId = $_SESSION["userId"] ?? null;
        if($currentUserId!=$params["userId"]) throw new RoleException("/","Vous n'êtes pas aurotisé à effectuer cette action");

        if(!$this->checkRole("admin")) throw new RoleException("/","Vous n'êtes pas aurotisé à effectuer cette action");

        // Call the service
        $this->userService->delete($params["userId"]);

        echo "utilisateur supprimé";

    }
}

?>