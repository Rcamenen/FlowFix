<?php
namespace App\Services;
use App\Models\TeamMemberModel;
use App\Models\FrictionModel;
use App\Models\CycleModel;
use App\Models\FrictionVoteModel;
use Exception;
use App\Models\TreatmentModel;
use App\Models\TreatmentVoteModel;
use DateTime;

class FrictionService{

    private TeamMemberModel $teamMemberModel;
    private CycleModel $cycleModel;
    private FrictionModel $frictionModel;
    private FrictionVoteModel $frictionVoteModel;
    private TreatmentModel $treatmentModel;
    private TreatmentVoteModel $treatmentVoteModel;

    public function __construct(){

        $this->teamMemberModel = new TeamMemberModel();
        $this->cycleModel = new CycleModel();
        $this->frictionModel = new FrictionModel();
        $this->frictionVoteModel = new FrictionVoteModel();
        $this->treatmentModel = new TreatmentModel();
        $this->treatmentVoteModel = new TreatmentVoteModel();
        
    }
    /** createUser()
     * Apply business verification & ask the model to add the user in the DB's user table.
     * 
     * @param {UserEntity} $userEntity : Object which represent user
     * @return bool true in case of success, false if not
     */

    public function getFrictionData($frictionId,$teamId,$userId){

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
            $treatmentCurrentVotes = $this->treatmentVoteModel->getVotesCounter($currentCycleId,$treatmentId);
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