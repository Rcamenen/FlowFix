<?php
namespace App\Exceptions;
use Exception;
use Throwable;

class ValidationException extends Exception{

    private ?array $errors=null;

    public function __construct(array $errors,$message, $code = 0, ?Throwable $previous = null) {
        
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);

    }

    public function getErrors(){

        return $this->errors;

    }

}


?>