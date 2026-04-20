<?php
namespace App\Controllers;

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

    /** showTeamDashboardPage()
     * Retrieve group's home data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (groupId, ...)
     * @return void Render group home view in case of success, throw exception if not
     */

    public function showTeamDashboardPage($params){
 
        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);
 
        $this->cycleService->syncCycle($params["teamId"]);
 
        $data = $this->teamService->getDashboardData($_SESSION["userId"],$params["teamId"]);
 
        $data["teamId"]      = $params["teamId"];
        $data["isModerator"] = (in_array($params["teamId"],$_SESSION["moderateTeamsId"])) ? true : false;
 
        $this->renderView("Team/teamDashboard",$data);
 
    }

    /** showFrictionsPage()
     * Retrieve group's frictions data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (teamId, ...)
     * @return void Render team frictions view in case of success, throw exception if not
     */
    public function showFrictionsPage($params){
 
        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);
 
        $page = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? (int) $_GET["page"] : 1;
 
        $data = $this->teamService->getFrictionsPage($params["teamId"], $page);
 
        $data["teamId"]      = $params["teamId"];
        $data["teamName"]    = $this->teamService->getTeamName($params["teamId"]);
        $data["isModerator"] = (in_array($params["teamId"],$_SESSION["moderateTeamsId"])) ? true : false;
 
        $this->renderView("team/teamFrictions",$data);
 
    }

    /** showCyclePage()
     * Sync the team's cycle then retrieve cycle data & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (teamId, ...)
     * @return void Render team cycle view in case of success, throw exception if not
     */
    public function showCyclePage($params){
 
        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);

        $this->cycleService->syncCycle($params["teamId"]);
 
        $data = $this->teamService->getCycleData($params["teamId"]);
 
        $data["teamId"]      = $params["teamId"];
        $data["teamName"]    = $this->teamService->getTeamName($params["teamId"]);
        $data["isModerator"] = (in_array($params["teamId"],$_SESSION["moderateTeamsId"])) ? true : false;
 
        $this->renderView("team/teamCycle",$data);
 
    }
    


    /** createTeam()
     * Check if the user is connected, collect POST data & initiate the team creation process.
     * Registers the new team in the user's session as owned and moderated, then redirects to /teams.
     * 
     * @param void
     * @return void Redirect to /teams in case of success, throw exception if not
     */
    public function createTeam(){

        $this->checkRole("user");

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

    /** addMember()
     * Add a new member to a team after verifying the current user's moderator role.
     * Collects the target email from POST data & delegates to the team service.
     * 
     * @param {Array} $params : Array which contain route params (teamId, ...)
     * @return void Render team member add confirmation view in case of success, throw exception if not
     */
    public function addMember($params){
 
        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);
        $this->checkRole("moderator",$params["teamId"]);

 
        $userId = $_SESSION["userId"] ?? null;
 
        $addMemberData = $this->getPost(["email"]);
 
        $teamId = $params["teamId"];
 
        $data = $this->teamService->addMember($addMemberData["email"],$teamId,$userId);
 
        $data["teamId"]      = $teamId;
        $data["teamName"]    = $this->teamService->getTeamName($teamId);
        $data["isModerator"] = true;
 
        $this->renderView("team/teamMemberAdd",$data); //header
 
    }

    /** showTeamCreationPage()
     * Verify the user is connected & render the team creation form view.
     * 
     * @param void
     * @return void Render team creation view in case of success, throw exception if not
     */
    public function showTeamCreationPage(){

        $this->checkRole("user");

        $this->renderView("/User/teamCreation");

    }

    /** showTeamMembersPage()
     * Retrieve the list of members for a given team & render the view for the current user.
     * 
     * @param {Array} $params : Array which contain route params (teamId, ...)
     * @return void Render team members view in case of success, throw exception if not
     */
    public function showTeamMembersPage($params){

        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);


        $data = $this->teamService->getMembers($params["teamId"]);

        $data["teamId"]      = $params["teamId"];
        $data["teamName"]    = $this->teamService->getTeamName($params["teamId"]);
        $data["isModerator"] = (in_array($params["teamId"],$_SESSION["moderateTeamsId"])) ? true : false;

        $this->renderView("Team/teamMembers",$data);

    }

    /** showAddMemberPage()
     * Verify the current user's moderator role & render the add member form view.
     * 
     * @param {Array} $params : Array which contain route params (teamId, ...)
     * @return void Render add member view in case of success, throw exception if not
     */
    public function showAddMemberPage($params){
 
        $this->checkRole("user");
        $this->checkRole("member",$params["teamId"]);
        $this->checkRole("moderator",$params["teamId"]);
 
        $data["teamId"]      = $params["teamId"];
        $data["teamName"]    = $this->teamService->getTeamName($params["teamId"]);
        $data["isModerator"] = true;
 
        $this->renderView("Team/Member/addMember",$data);
 
    }
}

?>