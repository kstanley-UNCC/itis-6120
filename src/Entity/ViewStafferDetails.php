<?php

namespace Itis6120\Project2\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(readOnly: true)]
#[Table(name: "view_staffer_details")]
class ViewStafferDetails extends AbstractEntity
{
    #[Column(name: "staffer_id")]
    #[Id]
    private int $id;

    #[Column(name: "staffer_honorific", nullable: true)]
    private ?string $honorific;

    #[Column(name: "staffer_name")]
    private string $name;

    #[Column(name: "staffer_email")]
    private string $email;

    #[Column(name: "staffer_position")]
    private string $position;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getHonorific(): ?string
    {
        return $this->honorific;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }
}
