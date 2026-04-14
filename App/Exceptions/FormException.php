<?php
namespace App\Exceptions;
use Exception;
use Throwable;

class FormException extends Exception{

    private ?array $errors=null;
    private ?string $view=null;

    public function __construct(array $errors,string $view,$message, $code = 0, ?Throwable $previous = null) {
        
        $this->errors = $errors;
        $this->view = $view;
        parent::__construct($message, $code, $previous);

    }

    public function getErrors(){

        return $this->errors;

    }

    public function getView(){

        return $this->view;

    }

}


?>