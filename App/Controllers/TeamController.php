<?php
namespace App\Controllers;
use App\Services\TeamService;
use Core\BaseController;
use Exception;
use App\Exceptions\ForbiddenException;
use App\Exceptions\UnauthorizedException;
use PDOException;

class TeamController extends BaseController{

    /** showDashboard()
     * Retrieve group's home data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (groupId, ...)
     * @return void Render group home view in case of success, throw exception if not
     */

    public function showDashboard($params){

        try{

            $userId = $_SESSION["userId"];    
            $userTeamsId = $_SESSION["teamsId"];  
            $currentTeamId = $params["teamId"];

            // Vérification des droits
            if(!$this->isUserConnected($userId)) throw new Exception("Vous devez être connecté pour accéder à cette page");
            if(!$this->isUserTeamMember($userTeamsId,$currentTeamId))throw new Exception("Vous ne faites pas partie de ce groupe");

            $userId = $_SESSION["userId"];
            $teamId = $params["teamId"];
            $teamService = new TeamService();
            $data=$teamService->home($userId,$teamId);

            $this->renderView("teamHome",$data);

        }catch(PDOException $e){
            echo $e->getMessage();
            $response["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            $this->renderView("teamsPanel",$response);

        }catch(ForbiddenException $e){
    
            echo $e->getMessage();

        }catch(UnauthorizedException $e){

            echo $e->getMessage();

        }
        catch(Exception $e){
            
            echo $e->getMessage();
            // $response["accessRightsError"] = $e->getMessage();
            // header("Location: \home");

        }
        


    }
}

?>