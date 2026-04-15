<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\UserService;
use App\Services\AdminService;

class AuthController extends BaseController{

    private UserService $userService;
    private AdminService $adminService;

    public function __construct()
    {
        $this->userService = new UserService;
        $this->adminService = new AdminService;
    }

    /** connectUser()
     * Retrieve login data from POST & ask the service to connect the user.
     * 
     * @return void Redirect to teams panel in case of success, throw exception if not
     */
    public function connectUser(){


        // ================== GETTING DATA =================== //

        $connectUserData = $this->getPost(["email","password"]);


        // ================== CONNEXION =================== //

        $sessionData = $this->userService->connectUser($connectUserData);
        $_SESSION['userId'] = $sessionData["userId"];
        $_SESSION['teamsId'] = $sessionData["teamsId"];
        $_SESSION['moderateTeamsId'] = $sessionData["moderateTeamsId"];

        // ================== REDIRECTION TO THE TEAMS PANEL =================== //

        header("Location: /teams?connected=true");
        exit();


    }

    /** disconnectUser()
     * Destroy the current session & redirect the user to the home page.
     * 
     * @return void Redirect to home page after session destruction
     */
    public function disconnectUser(){

        session_unset();
        $_SESSION["disconnect"]=true;
        header("Location: /");
        exit();

    }



    /** connectAdmin()
     * Check if the user is connected and retrieve their groups and invitations data from the service
     * Call the appropriate view to render the teams panel
     * @param {*}
     * @return void
     */
    public function connectAdmin(){

        // ================== GETTING DATA =================== //

        $connectAdminData = $this->getPost(["email","password"]);

        // ================== CONNEXION =================== //

        $sessionData = $this->adminService->connectAdmin($connectAdminData);
        
        $_SESSION['adminId'] = $sessionData["adminId"];

        // ================== REDIRECTION TO THE ADMIN PANEL =================== //

        header("Location: /adminPanel");
        exit();

    }

    public function disconnectAdmin(){

        session_destroy();
        $_SESSION["disconnect"]=true;
        header("Location: /");
        exit();

    }
}

?>