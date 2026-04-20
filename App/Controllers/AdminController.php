<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\AdminService;
use App\Services\UserService;

class AdminController extends BaseController{

    private AdminService $adminService;
    private UserService $userService;

    public function __construct()
    {
        $this->adminService = new AdminService;
        $this->userService = new UserService;
    }

    /** showAdminPanel()
     * Verify admin role & redirect to the users admin panel.
     * Displays a success message if the user has just logged in.
     * 
     * @param void
     * @return void Redirect to /admin/users in case of success, throw exception if not
     */
    public function showAdminPanel(){

        $this->checkRole("admin");

        // $data = $this->adminService->showAdminPanel($adminId); // userGroups / userInvitations /

        if(!empty($_GET["connected"])) $data["successMessage"] = "Connexion réussie";

        // $this->renderView("Admin/adminPanel",$data ?? null);
        header("Location:".BASE_URL."/admin/users");
        exit();

    }

    /** showUsers()
     * Verify admin role, retrieve paginated users list & render the admin users view.
     * 
     * @param void
     * @return void Render admin users view in case of success, throw exception if not
     */
    public function showUsers(){
 
        $this->checkRole("admin");

        $page = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? (int) $_GET["page"] : 1;
 
        $data = $this->adminService->getUsersPage($page);
 
        $this->renderView("Admin/adminUsers",$data);
 
    }

    /** showTeams()
     * Verify admin role, retrieve paginated teams list & render the admin teams view.
     * 
     * @param void
     * @return void Render admin teams view in case of success, throw exception if not
     */
    public function showTeams(){
 
        $this->checkRole("admin");

        $page = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? (int) $_GET["page"] : 1;
 
        $data = $this->adminService->getTeamsPage($page);
 
        $this->renderView("Admin/adminTeams",$data);
 
    }

    /** showDeleteUser()
     * Verify admin role, retrieve a user's data & render the delete confirmation view.
     * 
     * @param {Array} $params : Array which contain route params (userId, ...)
     * @return void Render admin user delete confirmation view in case of success, throw exception if not
     */
    public function showDeleteUser($params){
 
        $this->checkRole("admin");

        $data["user"] = $this->userService->getUser($params["userId"]);
 
        $this->renderView("Admin/adminUserDelete",$data);
 
    }

    /** deleteUser()
     * Verify admin role, permanently delete the target user & redirect to the users list.
     * 
     * @param {Array} $params : Array which contain route params (userId, ...)
     * @return void Redirect to /admin/users in case of success, throw exception if not
     */
    public function deleteUser($params){
 
        $this->checkRole("admin");

        $this->userService->delete($params["userId"]);
 
        header("Location:".BASE_URL."/admin/users");
        exit();
 
    }

}

?>