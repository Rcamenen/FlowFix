<?php
namespace App\Services;
use App\Models\User;
use App\Models\Member;
use App\Models\Group;
use App\Models\Treatment;
use App\Models\Cycle;
use App\Models\Friction;
use App\Entities\UserEntity;
use Exception;
use App\Exceptions\ValidationException;
use App\Exceptions\ForbiddenException;

class GroupService{

    /** createUser()
     * Apply business verification & ask the model to add the user in the DB's user table.
     * 
     * @param {UserEntity} $userEntity : Object which represent user
     * @return bool true in case of success, false if not
     */

    public function home($userId,$groupId){


        //VÉRIFICATION DES DROITS D'ACCÈS

        echo "<br> GroupService->home : <br>";

        $memberModel = new Member();
        $member = $memberModel->getMember($userId,$groupId); // Retourne l'id de membre du user au sein du groupe

        if(isset($member["left_at"]) && $member["left_at"] != null ) throw new ForbiddenException("Vous ne faites plus partie du groupe !");



        // ========================================
        // RÉCUPÉRATION DES INFORMATIONS À AFFICHER
        // ========================================

        // AFFICHER LES IRRITANTS DONT LE USER EST PILOTE

        /**
         * 
         * 1 - Récupérer le member_id correspondant au userId en session et au groupId passé en paramètre.
         * 2 - Récupérer le cycleId en cours à partir du groupId
         * 3 - Récupérer l'irritant selon le groupeId et le cycleId
         * 
         */
        
        // 1
        $memberId = $member["member_id"];

        // 2
        $treatmentModel = new Treatment();
        
        $treatment=$treatmentModel->findByMember($memberId);

        //3

        $frictionModel = new Friction();

        $friction=$frictionModel->findById($treatment["friction_id"]);

        $response["frictionToPilot"] = [
            "id"=>$friction["friction_id"],
            "title"=>$friction["title"],
            "description"=>$friction["description"],
            "creationDate"=>$friction["created_at"],
            "author"=>$friction["member_id"],
            "group_id"=>$friction["team_id"]
        ];

        return $response;
        // AFFICHER LES IRRITANTS QUI SONT EN COURS

        // AFFICHER LES IRRITANTS POUR LESQUELS ON A VOTÉ POUR LE PROCHAIN CYCLE

        // AFFICHER LE NOMBRE DE VOTE RESTANT


    }

}

?>