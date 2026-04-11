<?php
namespace App\Services;
use App\Models\TeamMemberModel;
use App\Models\FrictionModel;
use App\Models\CycleModel;
use App\Models\FrictionVotesModel;
use Exception;
use App\Models\TreatmentModel;
use App\Models\TreatmentVotesModel;
use DateTime;

class FrictionService{

    private TeamMemberModel $teamMemberModel;
    private CycleModel $cycleModel;
    private FrictionModel $frictionModel;
    private FrictionVotesModel $frictionVoteModel;
    private TreatmentModel $treatmentModel;
    private TreatmentVotesModel $treatmentVotesModel;

    public function __construct(){

        $this->teamMemberModel = new TeamMemberModel();
        $this->cycleModel = new CycleModel();
        $this->frictionModel = new FrictionModel();
        $this->frictionVoteModel = new FrictionVotesModel();
        $this->treatmentModel = new TreatmentModel();
        $this->treatmentVotesModel = new TreatmentVotesModel();
        
    }

    /** getFrictionData()
     * Retrieve and aggregate all friction-related data including votes, author, and latest treatment details from the models
     * Return a structured response array containing friction and treatment data
     * @param int $frictionId
     * @param int $teamId
     * @return array
     */
    public function getFrictionData(int $frictionId,int $teamId):array{

        echo "<br> FrictionService->getFrictionData : <br><br>";

        $currentCycleId = $this->cycleModel->getCurrentCycle($teamId);

        $frictionDataWithStatus = $this->frictionModel->getByIdWithStatus($frictionId);

        if(!$frictionDataWithStatus) throw new Exception("La page demandée n'existe pas"); //404

        $isFrictionOwnByTeam = $this->frictionModel->isOwnByTeam($frictionDataWithStatus['author_id'],$teamId); //Vérification de la cohérence friction/team.
        if(!$isFrictionOwnByTeam) throw new Exception("Cette friction ne fait pas partie de ce groupe !"); //404

        $response=[];

        $frictionVotes =  $this->frictionVoteModel->getVotesCounter($currentCycleId,$frictionId);
        $authorUsername = $this->frictionModel->getAuthorUsername($frictionId);

        $response["friction"]=[
                "id"=>$frictionDataWithStatus["id"],
                "title"=>$frictionDataWithStatus["title"],
                "description"=>$frictionDataWithStatus["description"],
                "statusLabel"=>$frictionDataWithStatus["status_label"],
                "author"=>$authorUsername,
                "votes"=>$frictionVotes,
                "created_at"=>$frictionDataWithStatus["created_at"],
                "updated_at"=>$frictionDataWithStatus["updated_at"]
            ];

        $treatmentsDataWithStatus = $this->treatmentModel->findLastsByFrictionWithStatus($frictionId, 5);
        if(!empty($treatmentsDataWithStatus)){

            $response["treatments"] = [];

            foreach($treatmentsDataWithStatus as $treatment){

                $treatmentVotes = $this->treatmentVotesModel->findVotesByTreatmentAndCycle($treatment["id"], $currentCycleId);
                $treatmentVotesCount = array_count_values($treatmentVotes);

                $pilotUsername = $this->treatmentModel->getPilotUsername($treatment["id"]);

                $response["treatments"][] = [
                    "id"=>$treatment["id"],
                    "solution"=>$treatment["solution"],
                    "created_at"=>$treatment["created_at"],
                    "updated_at"=>$treatment["updated_at"],
                    "statusLabel"=>$treatment["label"],
                    "pilot"=>$pilotUsername,
                    "forVotes" => $treatmentVotesCount[1] ?? 0,
                    "againstVotes" => $treatmentVotesCount[0] ?? 0
                ];
            }
        }

        return $response;

    }

    /** createFriction()
     * Retrieve the team member ID and send structured friction data to the model to handle the creation
     * Return the newly created friction entry
     * @param array $createFrictionData
     * @return array
     */
    public function createFriction($createFrictionData){

        echo "<br> FrictionService->createFriction : <br><br>";

        //Vérification de la longueur
        $memberId = $this->teamMemberModel->findMemberId($createFrictionData["userId"],$createFrictionData["teamId"]);

        $this->frictionModel->create([
            "created_at" => new DateTime()->format("Y-m-d H:i:s"),
            "title" => $createFrictionData["title"],
            "description"=>$createFrictionData["description"],
            "updated_at"=>null,
            "author_id"=>$memberId,
            "team_id"=>$createFrictionData["teamId"],
            "status_id"=>1
            ]
        );

        $frictionCreated = $this->frictionModel->getLastIdByAuthor($memberId);

        return $frictionCreated;

    }

    public function voteFriction($userId,$teamId,$frictionId){

        echo "<br> FrictionService->voteFriction : <br><br>";

        // Vérifier que la friction fais partie de la team

        // Vérifier que l'utilisaeur fait bien partie du groupe
        $memberId = $this->teamMemberModel->findMemberId($userId,$teamId);
        if(!$memberId) throw new Exception("Vous ne faites pas partie de ce groupe !");

        $cycle = $this->cycleModel->getLastByTeam($teamId);

        //Vérifier si le membre à atteind sont quota de vote
        $memberNbVotes = $this->frictionVoteModel->getCounterByMemberAndTeam($cycle["id"],$memberId);

        if($memberNbVotes > 3) throw new Exception("Vous avez atteind le nombre de vote maximal");

        $isVoteExist = $this->frictionVoteModel->findBy(["id"],["cycle_id"=>$cycle["id"],"member_id"=>$memberId,"friction_id"=>$frictionId]);

        if(!empty($isVoteExist)) throw new Exception("Vous avez déjà voté pour cet irritant");

        $this->frictionVoteModel->create([
            "vote"=>1,
            "voted_at"=> new DateTime()->format("Y-m-d H:i:s"),
            "cycle_id"=> $cycle["id"],
            "member_id"=> $memberId,
            "friction_id"=> $frictionId
        ]);

        return $response["success"]="Vote envoyé !";
    }

}

?>