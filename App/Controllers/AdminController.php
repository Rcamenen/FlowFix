<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\AdminService;

use App\Exceptions\RoleException;

class AdminController extends BaseController{

    private AdminService $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService;
    }


    public function showAdminPanel(){

        if(!$this->checkRole("admin")) throw new RoleException("admin/login","Vous devez d'abord vous connecter avec un compte administrateur pour voir cette page.");

        // $data = $this->adminService->showAdminPanel($adminId); // userGroups / userInvitations /

        if(!empty($_GET["connected"])) $data["successMessage"] = "Connexion réussie";

        $this->renderView("Admin/adminPanel",$data ?? null);

        exit();

    }

    /** showAdminPanel()
     * Check if the user is connected and retrieve their groups and invitations data from the service
     * Call the appropriate view to render the teams panel
     * @param {*}
     * @return void
     */
    public function showUsersPage(){
        if(!$this->checkRole("admin")) throw new RoleException("admin/login","Vous devez d'abord vous connecter avec un compte administrateur pour voir cette page.");

        $data = $this->adminService->showUsers(); // userGroups / userInvitations /

        $this->renderView("Admin/usersAdmin",$data ?? null);

        exit();

    }


    public function showTeamsPage(){
        if(!$this->checkRole("admin")) throw new RoleException("admin/login","Vous devez d'abord vous connecter avec un compte administrateur pour voir cette page.");

        $data = $this->adminService->showTeams(); // userGroups / userInvitations /

        $this->renderView("Admin/teamsAdmin",$data ?? null);

    }
}

?>