<?php
namespace App\Services;
use App\Models\User;
use App\Models\Member;
use App\Models\Group;
use App\Entities\UserEntity;
use Exception;
use App\Exceptions\ValidationException;
use DateTimeImmutable;

class UserService{

    /** createUser()
     * Apply business verification & ask the model to add the user in the DB's user table.
     * 
     * @param {UserEntity} $userEntity : Object which represent user
     * @return bool true in case of success, false if not
     */

    public function createUser($createUserData){

        $userModel = new User();  

        // ==================INPUT CHECKING=================== //

        // Checking if each field is filled
        foreach($createUserData as $data => $value){
            if(empty($value)) $errors[$data]= "Le champs $data est manquant !";
        }

        // Checking the email

        if(!filter_var($createUserData["email"],FILTER_VALIDATE_EMAIL)) $errors["email"]= "L'email est au mauvais format";
        if($userModel->isEmailExists($createUserData["email"])) $errors["email"]="L'email saisi existe déjà !";

        // Checking of the password

        if(strlen($createUserData["password"]) < 8) $errors["password"]="Le mot de passe doit contenir au moins 8 caractères";

        var_dump($errors);

        // Sending of the errors through Exception if exist

        if(isset($errors) && !empty($errors))throw new ValidationException($errors,"Champs incorrectes");

        // ================== USER CREATION =================== //

        $hash = password_hash($createUserData["password"],PASSWORD_DEFAULT);
        $registerDate = new DateTimeImmutable();

        $userEntity = new UserEntity(
            $registerDate,
            $createUserData["email"],
            $createUserData["firstname"],
            $createUserData["lastname"],
            $createUserData["username"],
            $hash
            );

        $userModel->createUser($userEntity);

    }

    /** connectUser()
     * Apply business verification & ask the model to connect the user with his credentials.
     * 
     * @param {Array} $connectUserData : Array which contain user's login informations
     * @return int user's id in case of success, throw exception if not
     */
    public function connectUser($connectUserData) :int | false {

        $userModel = new User();

        // ================== CHECKING DATA =================== //

        foreach($connectUserData as $data => $value){
            if(empty($value)) $errors[$data]= "Le champs $data est obligatoire !";
        }

        if(isset($errors)) throw new ValidationException($errors,"Champs login incorrects");

        // ================== MATCHING EMAIL/PASSWORD =================== //

        $userEntity = $userModel->getUserByEmail($connectUserData["email"]);
        if(!$userEntity) throw new Exception("Couple nom d'utilisateur / mot de passse incorrecte");
        
        $passwordMatch = password_verify($connectUserData["password"],$userEntity->getPassword());
        if(!$passwordMatch) throw new Exception("Couple nom d'utilisateur / mot de passse incorrecte");

        return $userEntity->getId() ?? false;

    }

    /** showGroupsPanel()
     * Retrieve all groups linked to a user & format them for the view.
     * 
     * @param {int} $userId : Id of the current user
     * @return array|false Array of user's groups in case of success, false if not
     */
    public function showGroupsPanel($userId) :array|false {

        $groupModel = new Group();

        $userGroupsEntity = $groupModel->getGroupsByUser($userId);

        foreach($userGroupsEntity as $userGroupEntity){

            $userGroup = [
                "groupId"=>$userGroupEntity->getId(),
                "groupName"=>$userGroupEntity->getName(),
                "groupDesc"=>$userGroupEntity->getDescription()
            ];

            $userGroups[]=$userGroup;

        }

        return $userGroups ?? false;

    }

}

?>