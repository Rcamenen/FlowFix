<?php
namespace App\Entities;
use DateTimeImmutable;

class UserEntity{

    protected readonly DateTimeImmutable $registerDate;
    protected readonly string $email;
    protected readonly string $firstname;
    protected readonly string $lastname;
    protected readonly string $username;
    protected readonly string $password;
    protected ?string $hash = null;

    public function __construct($registerDate,$email,$firstname,$lastname,$username,$password){

        $this->registerDate = $registerDate;
        $this->email=$email;
        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->username=$username;
        $this->password=$password;

    }

    public function getRegisterDate(){

        return $this->registerDate;

    }

    public function getEmail(){

        return $this->email;

    }

    public function getFirstname(){

        return $this->firstname;

    }

    public function getLastname(){

        return $this->lastname;

    }

    public function getUsername(){

        return $this->username;

    }

    public function getPassword(){

        return $this->password;

    }    
    
    public function getHash(){

        return $this->hash;

    }

    public function setHash($hash){

        $this->hash = $hash;

    }

}