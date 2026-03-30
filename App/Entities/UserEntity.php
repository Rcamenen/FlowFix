<?php
namespace App\Entities;
use DateTimeImmutable;

class UserEntity{

    protected ?int $id = null; 
    protected DateTimeImmutable $registerDate;
    protected string $email;
    protected string $firstname;
    protected string $lastname;
    protected string $username;
    protected string $password;

    public function __construct($registerDate,$email,$firstname,$lastname,$username,$password,$id=null){

        $this->registerDate = $registerDate;
        $this->email=$email;
        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->username=$username;
        $this->password=$password;
        $this->id = $id;

    }

    public function getId(){

        return $this->id;

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

    public function setHash($hash){

        $this->password = $hash;

    }

}