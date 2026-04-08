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
    public function getFrictionData($frictionId,$teamId){

        echo "<br> FrictionService->getFrictionData : <br><br>";

        $currentCycleId = $this->cycleModel->getCurrentCycle($teamId);

        $frictionDataWithStatus = $this->frictionModel->getByIdWithStatus($frictionId);

        if(!$frictionDataWithStatus) throw new Exception("La page demandée n'existe pas"); //404

        $frictionCurrentVotes =  $this->frictionVoteModel->getVotesCounter($currentCycleId,$frictionId);
        $authorUsername = $this->frictionModel->getAuthorUsername($frictionId);

        $response["friction"]=[
                "id"=>$frictionDataWithStatus["id"],
                "title"=>$frictionDataWithStatus["title"],
                "description"=>$frictionDataWithStatus["description"],
                "statusLabel"=>$frictionDataWithStatus["label"],
                "author"=>$authorUsername,
                "votes"=>$frictionCurrentVotes,
                "created_at"=>$frictionDataWithStatus["created_at"],
                "updated_at"=>$frictionDataWithStatus["updated_at"]
            ];

        $treatmentDataWithStatus = $this->treatmentModel->getLastByFrictionWithStatus($frictionId);
        if($treatmentDataWithStatus){

            $treatmentId=$treatmentDataWithStatus["id"];
            $treatmentCurrentVotes = $this->treatmentVotesModel->getVotesCounter($currentCycleId,$treatmentId);
            $pilotUsername = $this->treatmentModel->getPilotUsername($frictionId);

            $response["treatment"]=[
                "id"=>$treatmentDataWithStatus["id"],
                "solution"=>$treatmentDataWithStatus["solution"],
                "created_at"=>$treatmentDataWithStatus["created_at"],
                "updated_at"=>$treatmentDataWithStatus["updated_at"],
                "statusLabel"=>$treatmentDataWithStatus["label"],
                "pilot"=>$pilotUsername,
                "votes"=>$treatmentCurrentVotes,
            ];
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
        $memberId = $this->teamMemberModel->getMemberId($createFrictionData["userId"],$createFrictionData["teamId"]);

        $this->frictionModel->create([
            "created_at" => new DateTime()->format("Y-m-d h:i:s"),
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

}

?>