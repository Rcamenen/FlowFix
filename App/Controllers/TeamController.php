<?php
namespace App\Controllers;

use Core\BaseController;

use App\Services\TeamService;
use App\Services\CycleService;

use Exception;
use PDOException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\ValidationException;


class TeamController extends BaseController{

    private TeamService $teamService;
    private CycleService $cycleService;

    public function __construct() {

        $this->teamService = new TeamService();
        $this->cycleService = new CycleService();
        
    }

    /** showDashboard()
     * Retrieve group's home data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (groupId, ...)
     * @return void Render group home view in case of success, throw exception if not
     */

    public function showDashboard($params){

        try{
            $this->checkAccess($params);

            $this->cycleService->synchroCycle($params["teamId"]);

            $data=$this->teamService->getDashboardData($_SESSION["userId"],$params["teamId"]);
            
            $data["teamId"]= $params["teamId"];

            $this->renderView("teamDashboard",$data);

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

    /** create()
     * Check if the user is connected and initiate the team creation process
     * @param {*}
     * @return void
     */
    public function create(){

        echo "TeamController->create()";

        try{

            $userId = $_SESSION["userId"] ?? null;

            $this->isUserConnected($userId);

            $createTeamData = $this->getPost(["name","description","duration","treatmentsMax","votingDelay"]);
            $createTeamData["creatorId"]=$userId;

            $teamId = $this->teamService->create($createTeamData);

            $_SESSION["teamsId"][]=$teamId;

            header("Location: /teams");

        }catch(PDOException $e){
            echo $e->getMessage();
            $response["databaseError"] = "Nous rencontrons actuellement un problème technique, veuillez rééssayer plus tard...";
            $this->renderView("teamsPanel",$response);

        }catch(ForbiddenException $e){
    
            echo $e->getMessage();

        }catch(ValidationException $e){

            echo $e->getMessage();
            var_dump($e->getErrors());

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