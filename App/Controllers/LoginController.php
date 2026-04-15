<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\UserService;

class LoginController extends BaseController{

    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService;
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

        session_destroy();
        header("Location: /?disconnected=true");
        exit();

    }

    /** render()
     * Render the login view, redirect if user is already connected.
     * 
     * @return void Render login view with success message if account just created
     */
    public function showLoginPage(){

        if($this->isUserConnected()) header("Location: /");

        (!empty($_GET["registered"]) && $_GET["registered"]) ? $data["successMessage"]="Votre compte a bien été créé, vous pouvez dès à présent vous connecter !" : null;
        
        $this->renderView("Auth/login",$data ?? null);

    }
}

?>