<?php
namespace App\Services;

use Core\BaseService;

use App\Models\TeamMemberModel;
use App\Models\TeamModel;
use App\Models\CycleModel;
use App\Models\FrictionModel;
use App\Models\FrictionVotesModel;

use DateTime;

use App\Exceptions\ValidationException;

class TeamService extends BaseService{

    private TeamMemberModel $teamMemberModel;
    private TeamModel $teamModel;
    private CycleModel $cycleModel;
    private FrictionModel $frictionModel;
    private FrictionVotesModel $frictionVotesModel;

    public function __construct()
    {
        $this->teamMemberModel = new TeamMemberModel();
        $this->teamModel = new TeamModel();
        $this->frictionModel = new FrictionModel();
        $this->frictionVotesModel = new FrictionVotesModel();
        $this->cycleModel = new CycleModel();
    }


    /** getDashboardData()
     * Retrieve and aggregate dashboard data including the friction to pilot and frictions in progress for the given user and team
     * Return a structured response array containing the collected data
     * @param int $userId
     * @param int $teamId
     * @return array
     */
    public function getDashboardData($userId,$teamId){

        // ======================================== Retrieve teamMemberId

        $teamMemberId = $this->teamMemberModel->getMemberId($userId,$teamId);
        $currentCycle = $this->cycleModel->getCurrentCycle($teamId);
        // ======================================== Retrieve friction to pilot if exists

        $frictionsToPilot = $this->frictionModel->findByPilotAndCycle($teamMemberId,$currentCycle);
        $response["frictionsToPilot"] = $frictionsToPilot ?? null;

        // ======================================== Retrieve friction in progress if exists

        $frictionsInProgress = $this->frictionModel->findByGroupAndStatus($teamId,2);
        $response["frictionsInProgress"] = $frictionsInProgress ?? null;

        // ======================================== Retrieve given's votes number

        $votes = $this->frictionVotesModel->getCounterByMemberAndTeam($currentCycle,$teamMemberId);

        echo "<br>Nombre de votes : $votes <br>";

        return $response;

    }

    /** create()
     * Check the data sent by the controller
     * Ask teamModel to add the team table in DB
     * Ask teamMemberModel to add the creator to the teamMember table in DB and give him moderator role
     * Return a structured response array containing the collected data
     * @param array $createTeamData
     * @return void
     */
    public function create($createTeamData){

        $errors = $this->createTeamDataCheck($createTeamData);

        if($errors) throw new ValidationException($errors,"Au moins un champs du formulaire est incorrecte");

        // Adding new team to DB
        $teamId = $this->teamModel->create([
            "created_at" => new DateTime()->format("Y-m-d h:i:s"),
            "name" => $createTeamData["name"],
            "description" => $createTeamData["description"],
            "max_treatments_cycle_preset" => $createTeamData["treatmentsMax"],
            "cycle_duration_preset" => $createTeamData["duration"],
            "treatment_voting_delay_preset" => $createTeamData["votingDelay"],
            "creator_id" => $createTeamData["creatorId"]
        ]);

        // Adding new cycle to DB
        $this->cycleModel->create([
            "start_date" => new DateTime()->format("Y-m-d h:i:s"),
            "end_date" => new DateTime()->modify("+".$createTeamData["duration"]." days")->format("Y-m-d h:i:s"),
            "max_active_treatments" => $createTeamData["treatmentsMax"],
            "treatments_voting_delay" => $createTeamData["votingDelay"],
            "team_id" => $teamId
        ]);

        // Adding new teamMember to DB
        $this->teamMemberModel->create([
            "joined_at"=> new DateTime()->format("Y-m-d h:i:s"),
            "promoted_at"=> new DateTime()->format("Y-m-d h:i:s"),
            "team_id"=>$teamId,
            "user_id"=>$createTeamData["creatorId"]
        ]);

        $this->teamModel->getById($teamId);

        echo "Nouveau cycle créé";

        return $teamId;

    }

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

}

?>