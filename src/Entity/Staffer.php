<?php

namespace Itis6120\Project2\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "staff")]
class Staffer
{
    #[Column(name: "id", type: "integer")]
    #[Id]
    private int $id;

    #[ManyToOne(targetEntity: StaffPosition::class, cascade: ["persist"], fetch: "EXTRA_LAZY", inversedBy: "staffer")]
    private StaffPosition $position;

    #[Column(name: "date_login", type: "datetime_immutable", nullable: true, options: ["default" => null])]
    private ?DateTimeImmutable $dateLogin = null;

    #[Column(name: "email", type: "string", length: 255, unique: true)]
    private string $email;

    #[Column(name: "password", type: "string", length: 128)]
    private string $password;

    #[Column(name: "active", type: "boolean", options: ["default" => true])]
    private bool $active = true;

    #[Column(name: "honorific", type: "string", length: 10, nullable: true, options: ["default" => null])]
    private ?string $honorific = null;

    #[Column(name: "first_name", type: "string", length: 100)]
    private string $firstName;

    #[Column(name: "last_name", type: "string", length: 100)]
    private string $lastName;

    #[OneToMany(mappedBy: "doctor", targetEntity: PatientVisit::class, fetch: "EXTRA_LAZY")]
    private Collection $visits;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
    }

    public function addVisit(PatientVisit $visit): static
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->setDoctor($this);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return StaffPosition
     */
    public function getPosition(): StaffPosition
    {
        return $this->position;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getDateLogin(): ?DateTimeImmutable
    {
        return $this->dateLogin;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return Collection
     */
    public function getVisits(): Collection
    {
        return $this->visits;
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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return bool
     */
    public function hasVisits(): bool
    {
        return $this->getVisits()->count() > 0;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param int $id
     * @return Staffer
     */
    public function setId(int $id): Staffer
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param StaffPosition $position
     * @return Staffer
     */
    public function setPosition(StaffPosition $position): Staffer
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @param DateTimeImmutable|null $dateLogin
     * @return Staffer
     */
    public function setDateLogin(?DateTimeImmutable $dateLogin): Staffer
    {
        $this->dateLogin = $dateLogin;
        return $this;
    }

    /**
     * @param string $email
     * @return Staffer
     */
    public function setEmail(string $email): Staffer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     * @return Staffer
     */
    public function setPassword(string $password): Staffer
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param bool $active
     * @return Staffer
     */
    public function setActive(bool $active): Staffer
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @param string|null $honorific
     * @return Staffer
     */
    public function setHonorific(?string $honorific): Staffer
    {
        $this->honorific = $honorific;
        return $this;
    }

    /**
     * @param string $firstName
     * @return Staffer
     */
    public function setFirstName(string $firstName): Staffer
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param string $lastName
     * @return Staffer
     */
    public function setLastName(string $lastName): Staffer
    {
        $this->lastName = $lastName;
        return $this;
    }
}
