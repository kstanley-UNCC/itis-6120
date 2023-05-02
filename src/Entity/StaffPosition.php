<?php

namespace Itis6120\Project2\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "staff_positions")]
class StaffPosition
{
    #[Column(name: "id", type: "integer")]
    #[Id]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "position_name", type: "string", length: 50, unique: true)]
    private string $positionName;

    #[OneToMany(mappedBy: "position_id", targetEntity: Staffer::class)]
    private Staffer $staffer;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getPositionName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPositionName(): string
    {
        return $this->positionName;
    }

    /**
     * @return Staffer
     */
    public function getStaffer(): Staffer
    {
        return $this->staffer;
    }

    /**
     * @param int $id
     * @return StaffPosition
     */
    public function setId(int $id): StaffPosition
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $positionName
     * @return StaffPosition
     */
    public function setPositionName(string $positionName): StaffPosition
    {
        $this->positionName = $positionName;
        return $this;
    }

    /**
     * @param Staffer $staffer
     * @return StaffPosition
     */
    public function setStaffer(Staffer $staffer): StaffPosition
    {
        $this->staffer = $staffer;
        return $this;
    }
}
