<?php
namespace App\Controllers;
use App\Services\UserService;
use App\Entities\UserEntity;
use Core\BaseController;
use Exception;
use App\Exceptions\ValidationException;

class HomeController extends BaseController{

    public function render(){
        
        $this->renderView("home",$response ?? null);

    }
}

?>