<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\UserService;

use App\Exceptions\ValidationException;
use PDOException;
use Exception;

class RegisterController extends BaseController{

    private UserService $userService;

    public function __construct(){

        $this->userService = new UserService;

    }

    /** createUser()
     * Get $_POST values and send them to the service to continue the creation process
     * Call the appropriate view in case of success or failed in the process
     * @param {*}
     * @return void
     */
    public function createUser(){

        try{

            // ================== RÉCUPÉRATION DES DONNÉES =================== //
            
            $createUserData = $this->getPost(["email","firstname","lastname","username","password"]);

    
            // ================== APPEL DU SERVICE =================== //

            $this->userService->createUser($createUserData);

            // ================== REDIRECTION VERS LOGIN =================== //

            header('Location: /login?registered=true');
            exit();

        }
        catch(ValidationException $e){

            $data["failedMessage"] = "Un ou plusieurs champs sont incorrectes !";
            $data["validationErrors"] = $e->getErrors();
            $data["formFields"] = $createUserData;
            $this->renderView("register",$data);

        }        
        catch(PDOException $e){
            echo $e->getMessage();
            // $response["failedMessage"] = "Nous rencontrons actuellement des perturbations, veuillez rééssayer un plus plus tard...";
            // $this->renderView("register");

        }
        catch(Exception $e){
            echo $e->getMessage();
            // $this->renderView("register");
            //$this->renderView("ErrorPage",$Message d'erreur....)
        }

    }
    
    /** render()
     * Render the login view, redirect if user is already connected.
     * 
     * @return void Render login view with success message if account just created
     */
    public function render(){

        if($this->isUserConnected()) header("Location: /");
        $this->renderView("register");

    }
}

?>