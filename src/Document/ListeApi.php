<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class ListeApi {
    #[MongoDB\Id]
    protected $id;

    //#[MongoDB\EmbedOne(targetDocument: Prix::class)]
    //private $fields;

    #[MongoDB\Field(type: 'string')]
    protected $title;

    #[MongoDB\Field(type: 'string')]
    protected $tagline;

    #[MongoDB\Field(type: 'string')]
    protected $path;

    #[MongoDB\Field(type: 'string')]
    protected $slug;

    #[MongoDB\Field(type: 'string')]
    protected $openness;

    #[MongoDB\Field(type: 'string')]
    protected $owner;

    #[MongoDB\Field(type: 'raw')]
    protected $owner_acronym;

    #[MongoDB\Field(type: 'string')]
    protected $logo;

    #[MongoDB\Field(type: 'string')]
    protected $datapass_link;

    #[MongoDB\Field(type: 'collection')]
    protected array $datagouv_uuid =[];

    public function getId(): string {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getTagline(): string {
        return $this->tagline;
    }

    public function getPath(): string {
        return $this->path;
    }

    public function getSlug(): string {
        return $this->slug;
    }

    public function getOpenness(): string {
        return $this->openness;
    }

    public function getOwner(): string {
        return $this->owner;
    }

    public function getOwnerAcronym(): string {
        return $this->owner_acronym;
    }

    public function getLogo(): string {
        return $this->logo;
    }

    public function getDatapassLink(): string {
        return $this->datapass_link;
    }

    public function getDatagouvUuid(): array {
        return $this->datagouv_uuid;
    }

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setTagline(string $tagline): void {
        $this->tagline = $tagline;
    }

    public function setPath(string $path): void {
        $this->path = $path;
    }

    public function setSlug(string $slug): void {
        $this->slug = $slug;
    }

    public function setOpenness(string $openness): void {
        $this->openness = $openness;
    }

    public function setOwner(string $owner): void {
        $this->owner = $owner;
    }

    public function setOwnerAcronym(string $owner_acronym): void {
        $this->owner_acronym = $owner_acronym;
    }

    public function setLogo(string $logo): void {
        $this->logo = $logo;
    }

    public function setDatapassLink(string $datapass_link): void {
        $this->datapass_link = $datapass_link;
    }

    
    
}