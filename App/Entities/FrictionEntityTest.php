<?php
namespace App\Entities;
use DateTimeImmutable;

class FrictionEntityTest{

    protected ?int $id = null;
    protected ?DateTimeImmutable $created_at = null;
    protected ?string $title = null;
    protected ?string $description = null;
    protected ?DateTimeImmutable $updated_at=null;
    protected ?int $author_id = null;
    protected ?int $team_id = null;
    protected ?int $status_id = null;

    public function set($created_at,$title,$description,$updated_at,$author_id,$team_id,$status_id,$id=null){

        $this->id = $id;
        $this->created_at = $created_at;
        $this->title = $title;
        $this->description = $description;
        $this->updated_at = $updated_at;
        $this->author_id = $author_id;
        $this->team_id = $team_id;
        $this->status_id = $status_id;

    }

    public function toArray(): array{

        return get_object_vars($this);

    }

}