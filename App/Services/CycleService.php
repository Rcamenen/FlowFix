<?php
namespace App\Services;

use Core\BaseService;

use App\Models\FrictionModel;
use App\Models\CycleModel;
use App\Models\TreatmentModel;
use App\Models\TreatmentVotesModel;
use App\Models\TeamModel;
use App\Models\TeamMemberModel;

use DateTime;

use App\Exceptions\ValidationException;

class CycleService extends BaseService{

    private FrictionModel $frictionModel;
    private CycleModel $cycleModel;
    private TreatmentModel $treatmentModel;
    private TreatmentVotesModel $treatmentVotesModel;
    private TeamModel $teamModel;
    private TeamMemberModel $teamMemberModel;

    public function __construct (){

        $this->frictionModel = new FrictionModel;
        $this->cycleModel = new CycleModel;
        $this->treatmentModel = new TreatmentModel;
        $this->treatmentVotesModel = new TreatmentVotesModel;
        $this->teamModel = new TeamModel;
        $this->teamMemberModel = new TeamMemberModel;

    }

    function synchroCycle($teamId){

        echo "<br> CycleService->synchroCycle => TEST POUR SYNCHRO CYCLE : <br><br>";

        $currentTeamCycle = $this->cycleModel->getLastByTeam($teamId);
        $cycleEndDate = $currentTeamCycle["end_date"];

        if($cycleEndDate < (new DateTime())->format("Y-m-d h:i:s")){

            $this->endCycle($currentTeamCycle,$cycleEndDate,$teamId);
            $this->startCycle($teamId,$currentTeamCycle);

        }

        echo "Le cycle est en cours";

    }

    private function endCycle($currentTeamCycle,$cycleEndDate,$teamId){

            $cycleVotingDelay = $currentTeamCycle["treatments_voting_delay"];
            $endDateVoting = new DateTime($cycleEndDate)->modify("+".$cycleVotingDelay." days");

            $inProgressFrictions = $this->frictionModel->findInProgress($teamId);

            if(!$inProgressFrictions) return;

            foreach($inProgressFrictions AS $friction){

                $treatment = $this->treatmentModel->findByFrictionAndCycle($friction["f_id"],$currentTeamCycle["id"]);

                var_dump($treatment);

                if(!$treatment) $this->treatmentModel->create([ // Ne dois pas arriver
                    "created_at"=>new DateTime()->format("Y-m-d h:i:s"),
                    "pilot_id"=>0,
                    "status_id"=>2,
                    "cycle_id"=>$currentTeamCycle["id"],
                    "friction_id"=>$friction["f_id"]
                    ]);

                if(empty($treatment["solution"])){

                    $this->treatmentModel->update($treatment["id"],["solution"=>"Aucune solution n'a été proposée","status_id"=>5]);
                    $this->frictionModel->update($friction["f_id"],["status_id"=>4]);

                }else{

                    if($endDateVoting > (new DateTime())->format("Y-m-d h:i:s")){

                        $treatmentVotes = $this->treatmentVotesModel->getVotesCounter($currentTeamCycle["id"],$treatment["id"]);
                        $votes = array_count_values($treatmentVotes);

                        $votesFor = $votes[1] ?? 0;
                        $votesAgainst = $votes[0] ?? 0;

                        if($votesFor >= $votesAgainst){

                            $this->frictionModel->update($friction["f_id"],["status_id"=>4]);
                            $this->treatmentModel->update($treatment["id"],["status_id"=>4]);


                        }else{

                            $this->frictionModel->update($friction["f_id"],["status_id"=>4]);
                            $this->treatmentModel->update($treatment["id"],["status_id"=>5]);

                        }

                    }

                }

            }

            

    }

    private function startCycle($teamId,$oldCycle){

        $team = $this->teamModel->getById($teamId);

        $newCycleId = $this->cycleModel->create([
            "start_date" => new DateTime()->format("Y-m-d h:i:s"),
            "end_date" => new DateTime()->modify("+".$team["cycle_duration_preset"]." days")->format("Y-m-d h:i:s"),
            "max_active_treatments" => $team["max_treatments_cycle_preset"],
            "treatments_voting_delay" => $team["treatment_voting_delay_preset"],
            "team_id" => $team["id"]
        ]);

        $selectedFrictionsId = $this->frictionModel->findMostVoted($oldCycle["id"],$oldCycle["max_active_treatments"]);
        
        if($selectedFrictionsId){


            foreach($selectedFrictionsId as $frictionId){

                $this->frictionModel->update($frictionId,["status_id"=>2]);
                $this->treatmentModel->create([
                    "created_at"=> new DateTime()->format("Y-m-d h:i:s"),
                    "pilot_id"=> $this->teamMemberModel->getRandomMemberNotPilot($teamId,$newCycleId),
                    "status_id"=>1,
                    "cycle_id"=> $newCycleId,
                    "friction_id"=>$frictionId
                ]);

            }

        }

        echo "Nouveau cycle créé";

    }
    
}

?>