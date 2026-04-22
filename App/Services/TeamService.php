<?php
namespace App\Services;

use Core\BaseService;

use App\Models\TeamMemberModel;
use App\Models\TeamModel;
use App\Models\UserModel;
use App\Models\CycleModel;
use App\Models\FrictionModel;
use App\Models\FrictionVotesModel;

use DateTime;

use App\Exceptions\FormException;

class TeamService extends BaseService{

    private TeamMemberModel $teamMemberModel;
    private TeamModel $teamModel;
    private UserModel $userModel;
    private CycleModel $cycleModel;
    private FrictionModel $frictionModel;
    private FrictionVotesModel $frictionVotesModel;

    public function __construct()
    {
        $this->teamMemberModel = new TeamMemberModel();
        $this->teamModel = new TeamModel();
        $this->userModel = new UserModel();
        $this->frictionModel = new FrictionModel();
        $this->frictionVotesModel = new FrictionVotesModel();
        $this->cycleModel = new CycleModel();
    }


    /** getDashboardData()
     * Retrieve and aggregate dashboard data including team name, current cycle, frictions to pilot,
     * frictions in progress & votes cast by the current user for the active cycle.
     * Return a structured response array formatted for the team dashboard view.
     * 
     * @param {int} $userId : Id of the current user
     * @param {int} $teamId : Id of the team to retrieve data for
     * @return array Array of dashboard data in case of success, throw exception if not
     */
    public function getDashboardData($userId,$teamId){

        // RETRIEVE DATA

        $teamMemberId = $this->teamMemberModel->findMemberId($userId,$teamId);

        $teamName = $this->teamModel->findBy(["name"],["id"=>$teamId],"onecolumn");
        $response["teamName"]=$teamName ?? null;

        $currentCycle = $this->cycleModel->getCurrentCycle($teamId);
        $response["cycle"]=$currentCycle ?? null;

        $frictionsToPilot = $this->frictionModel->findByPilotAndCycle($teamMemberId,$currentCycle["id"]);
        $response["frictionsToPilot"] = $frictionsToPilot ?? null;

        $frictionsInProgress = $this->frictionModel->findByGroupAndStatus($teamId,2);
        $response["frictionsInProgress"] = $frictionsInProgress ?? null;

        $frictionsVotedId = $this->frictionVotesModel->findBy(["friction_id"],["cycle_id"=>$currentCycle["id"],"member_id"=>$teamMemberId],"column");
        
        // PREPARE DATA

        $response["frictionsVoted"]=[];

        foreach($frictionsVotedId as $friction){
            
            $frictionVoted = $this->frictionModel->getByIdWithStatus($friction);
            $frictionVoted["votes"] = $this->frictionVotesModel->getVotesCounter($currentCycle["id"],$friction);
            $response["frictionsVoted"][] = $frictionVoted;

        }

        // SEND DATA TO THE CONTROLLER

        return $response;

    }

    /** create()
     * Validate team creation data, then create the team, its initial cycle
     * & register the creator as a moderator member in the database.
     * Return the newly created team id.
     * 
     * @param {Array} $createTeamData : Array which contain team creation data (name, description, duration, treatmentsMax, votingDelay, creatorId)
     * @return int Id of the newly created team in case of success, throw exception if not
     */
    public function create($createTeamData){

        // CHECK DATA FROM USER

        $errors = $this->createTeamDataCheck($createTeamData);

        if($errors) throw new FormException($errors,"team/create","Au moins un champs du formulaire est incorrecte");

        // ADD TEAM TO DB
        $teamId = $this->teamModel->create([
            "created_at" => new DateTime()->format("Y-m-d H:i:s"),
            "name" => $createTeamData["name"],
            "description" => $createTeamData["description"],
            "max_treatments_cycle_preset" => $createTeamData["treatmentsMax"],
            "cycle_duration_preset" => $createTeamData["duration"],
            "treatment_voting_delay_preset" => $createTeamData["votingDelay"],
            "creator_id" => $createTeamData["creatorId"]
        ]);

        // ADD TEAM'S CYCLE TO DB
        $this->cycleModel->create([
            "start_date" => new DateTime()->setTime(0, 0, 0)->format("Y-m-d H:i:s"),
            "end_date" => new DateTime()->setTime(23, 59, 0)->modify("+".$createTeamData["duration"]." days")->format("Y-m-d H:i:s"),
            "max_active_treatments" => $createTeamData["treatmentsMax"],
            "treatments_voting_delay" => $createTeamData["votingDelay"],
            "team_id" => $teamId
        ]);

        // ADD CREATOR TO THE TEAM AS MEMBER MODERATOR
        $this->teamMemberModel->create([
            "joined_at"=> new DateTime()->format("Y-m-d H:i:s"),
            "promoted_at"=> new DateTime()->format("Y-m-d H:i:s"),
            "team_id"=>$teamId,
            "user_id"=>$createTeamData["creatorId"]
        ]);

        $this->teamModel->getById($teamId);

        // SEND NEW TEAM ID CREATED TO THE CONTROLLER
        return $teamId;

    }

    /** addMember()
     * Verify the moderator's role, resolve the new member by email,
     * check they are not already a member & register them to the team.
     * Return a response array containing a success or error message.
     * 
     * @param {string} $newMemberEmail : Email of the user to add
     * @param {int} $teamId : Id of the team to add the member to
     * @param {int} $userId : Id of the moderator performing the action
     * @return array Array containing success or error message in case of success, throw exception if not
     */
    public function addMember($newMemberEmail,$teamId,$userId){
        
        // CHECK IF MODERATOR ROLE
        $memberPromotedAt = $this->teamMemberModel->findBy(["promoted_at"],["user_id"=>$userId,"team_id"=>$teamId],"onecolumn");
        if(!$memberPromotedAt) $error = true;

        // CHECK IF THE EMAIL MATCH WITH USER
        $newMemberUserId = $this->userModel->findBy(["id"],["email"=>$newMemberEmail],"onecolumn");
        if(!$newMemberUserId) $error = "L'email saisi ne correspond à aucun utilisateur";

        // CHECK IF THE MEMBER IS NOT ALREADY BE PART OF THE TEAM
        $newMemberMemberId = $this->teamMemberModel->findBy(["id"],["user_id"=>$newMemberUserId,"team_id"=>$teamId],"onecolumn");
        if($newMemberMemberId) $error = "Cet utilisateur fait déjà partie du groupe";

        // CREATE TEAM MEMBER
        $response=[];

        if(!isset($error)){

            $this->teamMemberModel->create([
                "joined_at"=>(new DateTime())->format("Y-m-d H:i:s"),
                "team_id"=>$teamId,
                "user_id"=>$newMemberUserId
            ]);

            $response["formSuccess"]="Utilisateur ajouté au groupe";

        }

        $response["formError"] = $error ?? null;

        return $response;

    }

    /** createTeamDataCheck()
     * Validate team creation form data by checking required fields, name length & uniqueness,
     * description length, cycle duration & treatments max count.
     * 
     * @param {Array} $createTeamData : Array which contain team creation data
     * @return array|false Array of errors if any validation fails, false otherwise
     */
    public function createTeamDataCheck($createTeamData){


        // Checking if each field is filled
        foreach($createTeamData as $data => $value){
            if(empty($value)) $errors[$data]= "Le champs $data est manquant !";
        }

        // Checking the name length
        if(strlen($createTeamData["name"]) > 100 || strlen($createTeamData["name"]) < 2){
            $errors["name"]="Le nom doit contenir entre 2 et 100 caractères";
        }

        // Checking if the name is not already exists
        if($this->teamModel->findBy(["id"],["name"=>$createTeamData["name"]])){
            $errors["name"]="Ce nom est déjà utilisé";
        };

        // Checking the description length
        if(strlen($createTeamData["description"]) > 1000 || strlen($createTeamData["name"]) < 2){
            $errors["name"]="Le nom doit contenir entre 2 et 1000 caractères";
        }

        // Checking the treatmentsMax
        if($createTeamData["duration"] < 1){
            $errors["treatmentsMax"]="Le nombre de traitement à traiter par cycle doit supérieur à 0 !";
        }

        // Checking the treatmentsMax
        if($createTeamData["treatmentsMax"] < 1){
            $errors["treatmentsMax"]="Le nombre de traitement à traiter par cycle doit supérieur à 0 !";
        }

        // Checking the treatmentsMax
        if($createTeamData["votingDelay"] < 2){
            $errors["votingDelay"]="Le délais de vote d'un solution doit être d'au moins 1 jour !";
        }

        return $errors ?? false;

    }

    /** getFrictionsPage()
     * Retrieve a paginated list of frictions for a given team, enrich each entry
     * with its vote count for the current cycle & format pagination data for the view.
     * 
     * @param {int} $teamId : Id of the team to retrieve frictions for
     * @param {int} $page : Current page number (default: 1)
     * @param {int} $limit : Number of frictions per page (default: 10)
     * @return array Array containing frictions list, current page & total pages in case of success, throw exception if not
     */
    public function getFrictionsPage($teamId, $page = 1, $limit = 10){

        // ======================================== Retrieve frictions
        $offset = ($page - 1) * $limit;
        $frictions = $this->frictionModel->findByTeamPaginated($teamId, $limit, $offset);

        // ======================================== Retrieve current cycle
        $currentCycle = $this->cycleModel->getCurrentCycleId($teamId);

        // ======================================== Add vote count to each friction
        foreach($frictions as &$friction){
            $friction["votes"] = $this->frictionVotesModel->getVotesCounter($currentCycle, $friction["id"] ?? null);
        }

        // ======================================== Pagination data
        $total = $this->frictionModel->countByTeam($teamId);

        $response["frictions"]   = $frictions ?? null;
        $response["currentPage"] = $page;
        $response["totalPages"]  = (int) ceil($total / $limit);
        $response["teamId"]      = $teamId;

        return $response;

    }

    /** getMembers()
     * Retrieve all members of a team with their role.
     * 
     * @param {int} $teamId : Id of the team to retrieve members for
     * @return array Array of team members in case of success, throw exception if not
     */
    public function getMembers($teamId){
 
        $members = $this->teamMemberModel->findMembersByTeam($teamId);
        $response["members"] = $members ?? [];
 
        return $response;
 
    }

    /** getCycleData()
     * Retrieve the current cycle data for a given team.
     * 
     * @param {int} $teamId : Id of the team to retrieve the cycle for
     * @return array Array containing the current cycle data in case of success, throw exception if not
     */
    public function getCycleData($teamId){
 
        $currentCycle = $this->cycleModel->getCurrentCycle($teamId);
        $response["cycle"] = $currentCycle ?? null;
 
        return $response;
 
    }

    /** getTeamName()
     * Retrieve the name of a team by its id.
     * Used by the controller to populate the navigation partial.
     * 
     * @param {int} $teamId : Id of the team to retrieve the name for
     * @return string|null Team name in case of success, null if not found
     */
    public function getTeamName($teamId){
 
        return $this->teamModel->findBy(["name"],["id"=>$teamId],"onecolumn") ?? null;
 
    }

}

?>