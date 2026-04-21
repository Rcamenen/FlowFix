<?php
namespace App\Controllers;

use Core\BaseController;

class StaticPageController extends BaseController{

    /** showHomePage()
     * Render the home page view.
     * 
     * @param void
     * @return void Render home view
     */
    public function showHomePage(){
        
        if(!empty($_SESSION["adminId"])){
            header("Location:".BASE_URL."admin");
            exit();
        }
        
        $this->renderView("home",$response ?? null);

    }

    /** showPageNotFound()
     * Render the 404 not found error page view.
     * 
     * @param void
     * @return void Render 404 error view
     */
    public function showPageNotFound(){
        
        $this->renderView("Errors/404");

    }

    /** showRegisterPage()
     * Redirect to home if the user is already connected, otherwise render the registration form view.
     * 
     * @param void
     * @return void Render register view in case of success, redirect to home if already connected
     */
    public function showRegisterPage(){

        if($this->isUserConnected()) header("Location:".BASE_URL);
        $this->renderView("Auth/register");

    }


    /** showLoginPage()
     * Redirect to home if the user is already connected, otherwise render the login form view.
     * Displays a success message if the user has just created an account.
     * 
     * @param void
     * @return void Render login view in case of success, redirect to home if already connected
     */
    public function showLoginPage(){

        if($this->isUserConnected()) header("Location:".BASE_URL);

        (!empty($_GET["registered"]) && $_GET["registered"]) ? $data["successMessage"]="Votre compte a bien été créé, vous pouvez dès à présent vous connecter !" : null;
        
        $this->renderView("Auth/login",$data ?? null);

    }

    /** showAdminLoginPage()
     * Redirect to admin panel if the admin is already connected, otherwise render the admin login form view.
     * 
     * @param void
     * @return void Render admin login view in case of success, redirect to /admin if already connected
     */
    public function showAdminLoginPage(){

        if(!empty($_SESSION["adminId"])){
            header("Location:".BASE_URL."admin");
            exit();
        }

        $this->renderView("Admin/adminLogin",$data ?? null);

    }

    /** showErrorPage()
     * Redirect to the ErrorPage.
     * 
     * @param void
     * @return void Render admin login view in case of success, redirect to /admin if already connected
     */
    public function showErrorPage(){

        $this->renderView("Errors/technicalError");

    }

    /** showLegalPage()
     * Render the legal page view.
     * 
     * @param void
     * @return void Render legal page view
     */
    public function showLegalPage(){

        $this->renderView("Legal/legal",$data ?? null);

    }

    /** showPrivacyPage()
     * Render the privacy page view.
     * 
     * @param void
     * @return void Render privacy page view
     */
    public function showPrivacyPage(){

        $this->renderView("Privacy/privacy",$data ?? null);

    }

    /** showNotMember()
     * Render the not-member error page view.
     * 
     * @param void
     * @return void Render not-member error view
     */
    public function showNotMember(){
        
        $this->renderView("Errors/notMember",$data ?? null);

    }
}

?>