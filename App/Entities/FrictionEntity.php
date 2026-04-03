<?php
namespace App\Entities;
use DateTimeImmutable;

class FrictionEntity{

    protected ?int $id = null; 
    protected DateTimeImmutable $createdAt;
    protected string $title;
    protected string $description;
    protected ?DateTimeImmutable $updatedAt=null;
    protected int $author_id;
    protected int $team_id;
    protected int $status_id;

    public function __construct($created_at,$title,$description,$updated_at,$author_id,$team_id,$status_id,$id=null){

        $this->id = $id;
        $this->createdAt=$created_at;
        $this->title=$title;
        $this->description=$description;
        $this->updatedAt=$updated_at;
        $this->author_id=$author_id;
        $this->team_id=$team_id;
        $this->status_id=$status_id;

    }

    public function getId(){

        return $this->id;

    }

    public function getCreationDate(){

        return $this->createdAt;

    }

    public function getTitle(){

        return $this->title;

    }

    public function getDescription(){

        return $this->description;

    }

    public function getAuthorId(){

        return $this->author_id;

    }

    public function getTeamId(){

        return $this->team_id;

    }

    public function getStatusId(){

        return $this->status_id;

    }

    public function getUpdateDate(){

        return $this->updatedAt;

    }

}