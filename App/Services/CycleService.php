<?php
namespace App\Services;

use Core\BaseService;

use App\Models\FrictionModel;
use App\Models\FrictionVotesModel;
use App\Models\CycleModel;
use App\Models\TreatmentModel;
use App\Models\TreatmentVotesModel;
use App\Models\TeamModel;
use App\Models\TeamMemberModel;

use DateTime;

class CycleService extends BaseService{

    private FrictionModel $frictionModel;
    private FrictionVotesModel $frictionVotesModel;
    private CycleModel $cycleModel;
    private TreatmentModel $treatmentModel;
    private TreatmentVotesModel $treatmentVotesModel;
    private TeamModel $teamModel;
    private TeamMemberModel $teamMemberModel;

    public function __construct (){

        $this->frictionModel = new FrictionModel;
        $this->frictionVotesModel = new FrictionVotesModel;
        $this->cycleModel = new CycleModel;
        $this->treatmentModel = new TreatmentModel;
        $this->treatmentVotesModel = new TreatmentVotesModel;
        $this->teamModel = new TeamModel;
        $this->teamMemberModel = new TeamMemberModel;

    }

    /** syncCycle
     * 1 - Contrôle si un cycle est arrivé à échéance, si c'est le cas :
     *      -> Création d'un nouveau cycle
     *      -> Ouvre le session d'approbation des solutions proposées sur les frictions "en cours" qui passent à "en vote", les treatments passe à "à valider"
     * 2 - Cloture des frictions en votes avec un cycle dont la date est arrivée à échéance
     * @param int $teamId
     * @return void
     */
    function syncCycle($teamId){
        
        // echo "<br> CycleService->synchroCycle() <br>";

        // Cycle courant de la team
        $currentCycle = $this->cycleModel->getLastByTeam($teamId);

        // Date de fin du cycle courant
        $cycleEndDate = $currentCycle["end_date"];

        // Date du jour format
        $todayDate = (new DateTime())->format("Y-m-d H:i:s");

        // Le cycle est-il périmée ?
        if($todayDate > $cycleEndDate){

            // echo "<br> Cycle périmée <br>";

            // Les solutions proposées sont soumises au vote
            $this->openTreatmentsVotingSession($currentCycle["id"]);

            // On créer un nouveau cycle
            $newCycleId = $this->createCycle($teamId);

            // On créer un treatment, affecté au nouveau cycle, pour chaque frictions sélectionnées pour être traitées lors du dernier cycle
            $this->createTreatmentsFromTopVotedFrictions($currentCycle,$newCycleId,$teamId);

        }//else echo "Cycle non périmée"; // Else à supprimer lors de la mise en prod

            $this->closeTreatmentsVotingSession();

    }

    /** openTreatmentsVotingSession
     * Change les status des treatments et leur irritant à "en vote" si une solution est proposée
     * @param int $teamCycleId
     * @return void
     */
    private function openTreatmentsVotingSession(int $teamCycleId):void{

        // echo "<br> CycleService->openTreatmentsVotingSession() <br>";

        // Récupère les treatments d'un cycle;
        $treatmentsInProgress = $this->treatmentModel->findBy(["*"],["cycle_id"=>$teamCycleId]);

        foreach($treatmentsInProgress as $treatment){
            if(!empty($treatment["solution"])){

                $this->treatmentModel->update($treatment["id"],["status_id"=>3]); //treatment status_id 3 = A valider
                $this->frictionModel->update($treatment["friction_id"],["status_id"=>3]); //friction status_id 3 = En vote
                // echo '<br> treatments $treatment["id"] et frictions $treatment["friction_id"] passé au status 3 <br>';

            }else{

                $this->treatmentModel->update($treatment["id"],["status_id"=>5,"solution"=>"Aucune solution n'a été proposé"]); //treatment status_id 5 = Non validé
                $this->frictionModel->update($treatment["friction_id"],["status_id"=>4]); //friction status_id 4 = Clos
                // echo '<br> treatments $treatment["id"] et frictions $treatment["friction_id"] passé au status 5 & 4 <br>';

            }

        }

    }

    /** createCycle
     * Créer dans la bdd un nouveau cycle
     * @param int $teamId
     * @return int l'id du cycle créé
     */
    private function createCycle($teamId){
        // echo "<br> CycleService->createCycle() <br>";

        $team = $this->teamModel->getById($teamId);

        //Création d'un nouveau cycle
        return $this->cycleModel->create([
            "start_date" => new DateTime()->format("Y-m-d H:i:s"),
            "end_date" => new DateTime()->modify("+".$team["cycle_duration_preset"]." days")->format("Y-m-d H:i:s"),
            "max_active_treatments" => $team["max_treatments_cycle_preset"],
            "treatments_voting_delay" => $team["treatment_voting_delay_preset"],
            "team_id" => $team["id"]
        ]);

    }

    /** createTreatmentsFromTopVotedFrictions
     * Récolte les votes des treatments dont le délais de vote est dépassée
     * puis leur affecte un nouveau status selon le résultat des votes, ainsi qu'a leur friction.
     * @param int $pastCycle
     * @param int $newCycleId
     * @param int $teamId 
     * @return void
     */
    private function createTreatmentsFromTopVotedFrictions($pastCycle,$newCycleId,$teamId){
        // echo "<br> CycleService->createTreatmentsFromTopVotedFrictions() <br>";

        $topVotedFrictionsId = $this->frictionVotesModel->findMostVotedByCycle($pastCycle["id"],$pastCycle["max_active_treatments"]);
        foreach($topVotedFrictionsId as $frictionId){
            // var_dump($frictionId);
            $this->treatmentModel->create([
                "created_at" => (new DateTime())->format("Y-m-d H:i:s"),
                "pilot_id" => $this->teamMemberModel->getRandomMemberNotPilot($teamId,$newCycleId),
                "status_id" => 2, //treatment status_id 2 = -
                "cycle_id" => $newCycleId,
                "friction_id" => $frictionId
            ]);
            $this->frictionModel->update($frictionId,["status_id"=>2]);
        }

    }

    /** closeTreatmentsVotingSession
     * Récolte les votes des treatments dont le délais de vote est dépassée
     * puis leur affecte un nouveau status selon le résultat des votes, ainsi qu'a leur friction.
     * @param {*}
     * @return void
     */
    private function closeTreatmentsVotingSession(){
        // echo "<br> CycleService->closeTreatmentsVotingSession() <br>";

        $inVotingTreatments = $this->treatmentModel->findBy(["*"],["status_id"=>3]); // treatment status_id 3 = A valider

        foreach($inVotingTreatments as $treatment){

            $cycleData = $this->cycleModel->findBy(["end_date","treatments_voting_delay"],["id"=>$treatment["cycle_id"]],"oneassoc");
 
            $votingEndDate = new DateTime($cycleData["end_date"])->modify(("+".$cycleData["treatments_voting_delay"]." days"));

            if($votingEndDate < new DateTime()){

                // Dépouillement des résultats
                $votes = $this->treatmentVotesModel->findVotesByTreatmentAndStatus($treatment["id"],3);
                
                // Affectation des nouveaux statuts
                if(!empty($votes) && (array_sum($votes)/count($votes))>=0.5) $this->treatmentModel->update($treatment["id"],["status_id"=>4]); // treatment status_id 4 = Validé
                else $this->treatmentModel->update($treatment["id"],["status_id"=>5]); // treatment status_id 5 = Non validé

                $this->frictionModel->update($treatment["friction_id"],["status_id"=>4]); // friction status_id 4 = Clos

            }            

        }

    }

    

    

}

?>