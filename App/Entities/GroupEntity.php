<?php
namespace App\Entities;
use DateTimeImmutable;

class GroupEntity{

    protected ?int $id = null; 
    protected DateTimeImmutable $creationDate;
    protected string $name;
    protected string $description;
    protected string $creator_id;

    public function __construct($creationDate,$name,$description,$creator_id,$id=null){

        $this->id = $id;
        $this->creationDate=$creationDate;
        $this->name=$name;
        $this->description=$description;
        $this->creator_id=$creator_id;

    }

    public function getId(){

        return $this->id;

    }

    public function getCreationDate(){

        return $this->creationDate;

    }

    public function getName(){

        return $this->name;

    }

    public function getDescription(){

        return $this->description;

    }

    public function getCreatorId(){

        return $this->creator_id;

    }

}