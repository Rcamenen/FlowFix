<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\FrictionService;

use Exception;
use PDOException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\UnauthorizedException;


class FrictionController extends BaseController{

    private FrictionService $frictionService;

    public function __construct()
    {
        $this->frictionService = new FrictionService;
    }

    /** getFrictionView()
     * Retrieve friction data from the service using session and route parameters
     * Call the appropriate view to render the friction page
     * @param array $params Route parameters containing teamId and frictionId
     * @return void
     */
    public function getFrictionView($params){

        try{
            //Vérification des droits
            $this->checkAccess($params);

            $userId = $_SESSION["userId"] ?? null;
            $currentTeamId = $params["teamId"] ?? null;
            $frictionId = $params["frictionId"] ?? null;



            $data = $this->frictionService->getFrictionData($frictionId,$currentTeamId,$userId);
            $data["teamId"] = $currentTeamId;

            $this->renderView("/team/friction/frictionDetails",$data);

        }
        catch(PDOException $e){
            echo $e->getTraceAsString();
            echo "<br>";
            echo $e->getMessage();
            $response["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            // $this->renderView("groupsPanel",$response);
        }
        catch(ForbiddenException $e){echo $e->getMessage();}
        catch(UnauthorizedException $e){echo $e->getMessage();}
        catch(Exception $e){echo $e->getMessage();
            // $response["accessRightsError"] = $e->getMessage();
            // header("Location: \");
        }
        


    }

    /** createFriction()
     * Get $_POST values and route parameters, structure them and send to the service to handle friction creation
     * Redirect to the newly created friction page on success
     * @param array $params Route parameters containing teamId
     * @return void
     */
    public function createFriction($params){

        try{

            $this->checkAccess($params);

            // Récupération et structuration des données pour appel au service
            $createFrictionData = $this->getPost(["title","description"]);
            $createFrictionData["userId"]=$_SESSION["userId"];
            $createFrictionData["teamId"]=$params["teamId"];

            // Appel au service
            $frictionCreatedId = $this->frictionService->createFriction($createFrictionData);

            header("Location: /team/".$createFrictionData["teamId"]."/friction/".$frictionCreatedId["id"]);

        }
        catch(PDOException $e){$e->getMessage();
            $response["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            // $this->renderView("groupsPanel",$response);
        }
        catch(ForbiddenException $e){echo $e->getMessage();}
        catch(UnauthorizedException $e){echo $e->getMessage();}
        catch(Exception $e){echo $e->getMessage();
            // $response["accessRightsError"] = $e->getMessage();
            // header("Location: /");
        }
        

    }

    public function voteFriction($params){

        try{
            echo "<br> FrictionController->voteFriction : <br><br>";

            //team/id/friction/id/vote
            $this->checkAccess($params);
            
            $userId = $_SESSION["userId"];
            $teamId = $params["teamId"];
            $frictionId = $params["frictionId"];

            $this->frictionService->voteFriction($userId,$teamId,$frictionId);
            //team/id/friction/id/unvote

        }
        catch(PDOException $e){$e->getMessage();
            $response["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
        }
        catch(ForbiddenException $e){echo $e->getMessage();}
        catch(UnauthorizedException $e){echo $e->getMessage();}
        catch(Exception $e){echo $e->getMessage();
        }

    }
    
    /** renderCreationForm()
     * Retrieve the current team context and pass it to the service to render the friction creation form view
     * @param array $params Route parameters containing teamId
     * @return void
     */
    public function renderCreationForm($params){
        try{

            $this->checkAccess($params);

            $currentTeamId = $params["teamId"];

            $data=[
                "teamId"=>$currentTeamId
            ];

            $this->renderView("/team/friction/frictionCreation",$data);

        }
        catch(PDOException $e){echo $e->getMessage();
            $response["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            // $this->renderView("groupsPanel",$response);
        }
        catch(ForbiddenException $e){echo $e->getMessage();}
        catch(UnauthorizedException $e){echo $e->getMessage();}
        catch(Exception $e){echo $e->getMessage();
            // $response["accessRightsError"] = $e->getMessage();
            // header("Location: /");
        }

    }
}



?>