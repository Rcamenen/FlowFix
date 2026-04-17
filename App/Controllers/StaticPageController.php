<?php
namespace App\Controllers;

use Core\BaseController;

class StaticPageController extends BaseController{

    /** showHomePage()
     * Render the home page view
     * @param {*}
     * @return void
     */
    public function showHomePage(){
        
        $this->renderView("home",$response ?? null);

    }

    /** showPageNotFound()
     * Render the 404 not found page view
     * @param {*}
     * @return void
     */
    public function showPageNotFound(){
        
        $this->renderView("Errors/404",$response ?? null);

    }

    /** showRegisterPage()
     * Render the login view, redirect if user is already connected.
     * 
     * @return void
     */
    public function showRegisterPage(){

        if($this->isUserConnected()) header("Location: /");
        $this->renderView("Auth/register");

    }


    /** showLoginPage()
     * Render the login view, redirect if user is already connected.
     * 
     * @return void
     */
    public function showLoginPage(){

        if($this->isUserConnected()) header("Location: /");

        (!empty($_GET["registered"]) && $_GET["registered"]) ? $data["successMessage"]="Votre compte a bien été créé, vous pouvez dès à présent vous connecter !" : null;
        
        $this->renderView("Auth/login",$data ?? null);

    }

    /** showAdminLoginPage()
     * Render the adminlogin view.
     * 
     * @return void Render login view with success message if account just created
     */
    public function showAdminLoginPage(){
        
        $this->renderView("Admin/adminLogin",$data ?? null);

    }
}

?>