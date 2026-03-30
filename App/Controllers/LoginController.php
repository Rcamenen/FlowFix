<?php
namespace App\Controllers;
use App\Services\UserService;
use App\Entities\UserEntity;
use Core\BaseController;
use Exception;
use PDOException;
use App\Exceptions\ValidationException;

class LoginController extends BaseController{

    /** connectUser()
     * Retrieve login data from POST & ask the service to connect the user.
     * 
     * @return void Redirect to teams panel in case of success, throw exception if not
     */
    public function connectUser(){

        try{

            // ================== GETTING DATA =================== //

            $connectUserData = $this->getPost(["email","password"]);


            // ================== CONNEXION =================== //
            
            $userService = new UserService();
            $userId = $userService->connectUser($connectUserData);
            $_SESSION['userId'] = $userId;


            // ================== REDIRECTION TO THE TEAMS PANEL =================== //

            header("Location: /teams?connected=true");
            exit();

        }catch(ValidationException $e){

            echo $e->getMessage();
            // $data["validationErrors"] = $e->getErrors();
            // $this->renderView("login",$data);

        }catch(PDOException $e){

            echo $e->getMessage();
            // $data["failedMessage"] = "Nous rencontrons actuellement des perturbations, veuillez rééssayer un plus plus tard...";
            // $this->renderView("login",$data);

        }
        catch(Exception $e){

            echo $e->getMessage();

        }

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
    public function render(){

        if($this->isUserConnected()) header("Location: /");

        (!empty($_GET["registered"]) && $_GET["registered"]) ? $data["successMessage"]="Votre compte a bien été créé, vous pouvez dès à présent vous connecter !" : null;
        
        $this->renderView("login",$data ?? null);

    }
}

?>