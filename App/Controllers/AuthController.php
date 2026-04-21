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
     * Collect login credentials from POST data & delegate user authentication to the service.
     * Store session data on success & redirect to the teams panel.
     * 
     * @param void
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
        $_SESSION['username'] = $sessionData["username"];

        // ================== REDIRECTION TO THE TEAMS PANEL =================== //

        header("Location: ".BASE_URL."teams");
        exit();


    }

    /** disconnectUser()
     * Unset the current session & redirect the user to the home page.
     * 
     * @param void
     * @return void Redirect to home page after session destruction
     */
    public function disconnectUser(){

        session_unset();
        $_SESSION["disconnect"]=true;
        header("Location: ".BASE_URL);
        exit();

    }



    /** connectAdmin()
     * Collect login credentials from POST data & delegate admin authentication to the service.
     * Store session data on success & redirect to the admin panel.
     * 
     * @param void
     * @return void Redirect to admin panel in case of success, throw exception if not
     */
    public function connectAdmin(){

        // ================== GETTING DATA =================== //

        $connectAdminData = $this->getPost(["email","password"]);

        // ================== CONNEXION =================== //

        $sessionData = $this->adminService->connectAdmin($connectAdminData);
        
        $_SESSION['adminId'] = $sessionData["adminId"];

        // ================== REDIRECTION TO THE ADMIN PANEL =================== //

        header("Location:".BASE_URL."admin/users");
        exit();

    }

    /** disconnectAdmin()
     * Destroy the current session & redirect the admin to the home page.
     * 
     * @param void
     * @return void Redirect to home page after session destruction
     */
    public function disconnectAdmin(){

        session_destroy();
        $_SESSION["disconnect"]=true;
        header("Location: ".BASE_URL."");
        exit();

    }
}

?>