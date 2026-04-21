<?php
namespace App\Controllers;

use App\Exceptions\RoleException;
use Core\BaseController;

use App\Services\UserService;

class UserController extends BaseController{

    private UserService $userService;

    public function __construct(){
        $this->userService = new UserService;
    }

    /** showTeamsPage()
     * Retrieve the current user's teams and invitations data & render the teams panel view.
     * Displays a success message if the user has just logged in.
     * 
     * @param void
     * @return void Render teams panel view in case of success, throw exception if not
     */
    public function showTeamsPage(){

        $userId = $_SESSION["userId"] ?? null;

        $this->checkRole("user");

        $data = $this->userService->showGroupsPanel($userId); // userGroups / userInvitations /

        $this->renderView("User/teamsPanel",$data);

        exit();

    }

    /** showAccountPage()
     * Retrieve the current user's account data & render the profile view.
     * 
     * @param void
     * @return void Render profile view in case of success, throw exception if not
     */
    public function showAccountPage(){

        $this->checkRole("user");

        $userId = $_SESSION["userId"] ?? null;
        $data = $this->userService->getAccountData($userId);

        $this->renderView("User/profil",$data);

    }


    /** createUser()
     * Collect registration data from POST & delegate user creation to the service.
     * Redirect to the login page on success.
     * 
     * @param void
     * @return void Redirect to login page in case of success, throw exception if not
     */
    public function createUser(){

        // ================== RÉCUPÉRATION DES DONNÉES =================== //
        
        $createUserData = $this->getPost(["email","firstname","lastname","username","password"]);


        // ================== APPEL DU SERVICE =================== //

        $this->userService->createUser($createUserData);

        // ================== REDIRECTION VERS LOGIN =================== //

        header("Location: ".BASE_URL."login");
        exit();

    }

    /** deleteUser()
     * Verify the current user's identity, ensure they can only delete their own account
     * & delegate deletion to the service.
     * 
     * @param {Array} $params : Array which contain route params (userId, ...)
     * @return void Delete user in case of success, throw exception if not
     */
    public function deleteUser($params){

        $this->checkRole("user");

        $currentUserId = $_SESSION["userId"] ?? null;
        if($currentUserId!=$params["userId"]) throw new RoleException("/","Vous n'êtes pas aurotisé à effectuer cette action");

        $this->userService->delete($params["userId"]);

    }
}

?>