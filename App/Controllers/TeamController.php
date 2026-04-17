<?php
namespace App\Controllers;

use App\Exceptions\AuthenticateException;
use App\Exceptions\AuthorizationException;
use App\Exceptions\RoleException;
use Core\BaseController;

use App\Services\TeamService;
use App\Services\CycleService;

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

    public function showTeamPage($params){

        if(!$this->checkRole("user",$params["teamId"])) throw new AuthenticateException("Vous devez vous connecter pour accéder à un groupe !");
        if(!$this->checkRole("member",$params["teamId"]))throw new AuthorizationException("teams","Vous devez faire partie du groupe pour l'afficher");

        $this->cycleService->syncCycle($params["teamId"]);

        $data=$this->teamService->getDashboardData($_SESSION["userId"],$params["teamId"]);
        
        $data["teamId"]= $params["teamId"];
        $data["isModerator"]= (in_array($params["teamId"],$_SESSION["moderateTeamsId"]))?true:false;

        $this->renderView("team/teamDashboard",$data);

    }

    /** showDashboard()
     * Retrieve group's home data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (groupId, ...)
     * @return void Render group home view in case of success, throw exception if not
     */

    public function showTeamFrictionsPage($params){

        if(!$this->checkRole("user",$params["teamId"])) throw new AuthenticateException("Vous devez vous connecter pour accéder à un groupe !");
        if(!$this->checkRole("member",$params["teamId"]))throw new AuthorizationException("teams","Vous devez faire partie du groupe pour l'afficher");

        $this->cycleService->syncCycle($params["teamId"]);

        $data=$this->teamService->getFrictionsData($_SESSION["userId"],$params["teamId"]);
        
        $data["teamId"]= $params["teamId"];
        $data["isModerator"]= (in_array($params["teamId"],$_SESSION["moderateTeamsId"]))?true:false;

        $this->renderView("team/teamFrictions",$data);

    }

    /** create()
     * Check if the user is connected and initiate the team creation process
     * @param {*}
     * @return void
     */
    public function createTeam(){

        if(!$this->checkRole("user")) throw new RoleException("login","Vous devez d'abord vous connecter pour créer un groupe !");

        echo "TeamController->create()";

        $userId = $_SESSION["userId"] ?? null;

        $this->isUserConnected($userId);

        $createTeamData = $this->getPost(["name","description","duration","treatmentsMax","votingDelay"]);
        $createTeamData["creatorId"]=$userId;

        $teamId = $this->teamService->create($createTeamData);

        $_SESSION["teamsId"][]=$teamId;
        $_SESSION["moderateTeamsId"][]=$teamId;

        header("Location: /teams");

    }

    public function addMember($params){

        if(!$this->checkRole("user")) throw new RoleException("team/".$params["teamId"],"Vous devez d'abord vous connecter pour ajouter un membre à un groupe");
        if(!$this->checkRole("member",$params["teamId"])) throw new RoleException("team/".$params["teamId"],"Vous devez être membre et modérateur pour ajouter un membre à un groupe");
        if(!$this->checkRole("moderator",$params["teamId"])) throw new RoleException("team/".$params["teamId"],"Vous devez être modérateur du groupe pour ajouter un membre");

        $userId = $_SESSION["userId"] ?? null;

        $addMemberData = $this->getPost(["email"]);
        
        //==================================================================== <<<<<<<<<<<<<<<
        //Ajouter un check de l'email (méthode php)

        $teamId = $params["teamId"];

        $data = $this->teamService->addMember($addMemberData["email"],$teamId,$userId);

        // header("Location: /teams");
        $this->renderPartial("Partials/addMemberForm",$data);

    }

    public function showAddMember(){

        $this->renderPartial("Partials/addMemberForm");

    }

    public function showFrictions($params) {

        $this->checkAccess($params);

        $page = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? (int) $_GET["page"] : 1;

        $data = $this->teamService->getFrictionsPage(
                $params["teamId"],
                $page
            );

        $this->renderPartial("Partials/frictionsList",$data);

    }

    public function showTeamCreationPage(){

        if(!$this->checkRole("user")) throw new RoleException("login","Il faut être connecté pour créer un groupe");
        $this->renderView("/User/teamCreation");

    }
}

?>