<?php
namespace App\Exceptions;
use Exception;
use Throwable;

class RoleException extends Exception{

    private ?string $view=null;

    public function __construct(string $view,$message, $code = 0, ?Throwable $previous = null) {
        
        $this->view = $view;
        parent::__construct($message, $code, $previous);

    }

    public function getView(){

        return $this->view;

    }

}

?>