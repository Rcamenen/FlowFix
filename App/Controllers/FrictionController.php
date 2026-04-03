<?php
namespace App\Controllers;
use App\Services\FrictionService;
use Core\BaseController;
use Exception;
use App\Exceptions\ForbiddenException;
use App\Exceptions\UnauthorizedException;
use PDOException;

class FrictionController extends BaseController{

    private FrictionService $frictionService;

    public function __construct()
    {
        $this->frictionService = new FrictionService;
    }

    /** home()
     * Retrieve group's home data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (groupId, ...)
     * @return void Render group home view in case of success, throw exception if not
     */

    public function getFrictionView($params){

        try{

            $userId = $_SESSION["userId"] ?? null;    
            $userTeamsId = $_SESSION["teamsId"] ?? null;
            $currentTeamId = $params["teamId"] ?? null;
            $frictionId = $params["frictionId"] ?? null;

            // Vérification des droits
            if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");
            if(!$this->isUserTeamMember($userTeamsId,$currentTeamId))throw new Exception("Vous ne faites pas partie de ce groupe");

            $data = $this->frictionService->getFrictionData($frictionId,$currentTeamId,$userId);

            $this->renderView("friction",$data);

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

    public function createFriction($params){

        try{
            $userId = $_SESSION["userId"];    
            $userTeamsId = $_SESSION["teamsId"];  
            $currentTeamId = $params["teamId"];

            // Vérification des droits
            if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");
            if(!$this->isUserTeamMember($userTeamsId,$currentTeamId))throw new Exception("Vous ne faites pas partie de ce groupe");

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

    public function voteFriction(){

        //team/id/friction/id/vote
        //team/id/friction/id/unvote

    }

    public function renderCreationForm($params){
        try{

            $userId = $_SESSION["userId"];    
            $userTeamsId = $_SESSION["teamsId"];  
            $currentTeamId = $params["teamId"];
            // Vérification des droits
            if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");
            if(!$this->isUserTeamMember($userTeamsId,$currentTeamId))throw new Exception("Vous ne faites pas partie de ce groupe");
            $data=[
                "teamId"=>$currentTeamId
            ];
            $this->renderView("frictionCreation",$data);

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