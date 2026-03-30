<?php
namespace App\Controllers;
use App\Services\UserService;
use App\Entities\UserEntity;
use Core\BaseController;
use Exception;
use DateTimeImmutable;
use App\Exceptions\ValidationException;

class ErrorController extends BaseController{

    /** createUser()
     * Make the first control on $_POST values and send it to the service to continue the creation process
     * Call the appropriate view in case of success or failed in the process
     * @param {*}
     * @return void
     */

    public function pageNotFound(){

        $this->renderView("404");

    }
}

?>