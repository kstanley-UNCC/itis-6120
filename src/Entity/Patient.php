<?php

namespace Itis6120\Project2\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "patients")]
class Patient extends AbstractEntity
{
    #[Column(name: "id", type: "integer")]
    #[Id]
    #[GeneratedValue]
    private int $id;

    private $insurance;

    #[Column(name: "gender", type: "string", length: 2)]
    private string $gender;

    #[Column(name: "honorific", type: "string", length: 10, nullable: true, options: ["default" => null])]
    private ?string $honorific = null;

    #[Column(name: "first_name", type: "string", length: 100)]
    private string $firstName;

    #[Column(name: "last_name", type: "string", length: 100)]
    private string $lastName;

    #[Column(name: "middle_initial", type: "string", length: 1, nullable: true, options: ["default" => null])]
    private ?string $middleInitial = null;

    #[Column(name: "email", type: "string", length: 255)]
    private string $email;

    #[Column(name: "ssn", type: "string", length: 11, unique: true)]
    private string $ssn;

    #[Column(name: "dob", type: "date_immutable", nullable: true, options: ["default" => null])]
    private ?DateTimeImmutable $dob = null;

    #[OneToMany(mappedBy: "patient", targetEntity: PatientVisit::class, fetch: "EXTRA_LAZY")]
    private Collection $visits;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
    }

    /**
     * @param PatientVisit $visit
     * @return $this
     */
    public function addVisit(PatientVisit $visit): static
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->setPatient($this);
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
     * @return mixed
     */
    public function getInsurance(): mixed
    {
        return $this->insurance;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
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
     * @return string|null
     */
    public function getMiddleInitial(): ?string
    {
        return $this->middleInitial;
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
    public function getSsn(): string
    {
        return $this->ssn;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getDob(): ?DateTimeImmutable
    {
        return $this->dob;
    }

    /**
     * @return Collection
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $insurance
     * @return $this
     */
    public function setInsurance(mixed $insurance): static
    {
        $this->insurance = $insurance;
        return $this;
    }

    /**
     * @param string $gender
     * @return $this
     */
    public function setGender(string $gender): static
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @param string|null $honorific
     * @return $this
     */
    public function setHonorific(?string $honorific): static
    {
        $this->honorific = $honorific;
        return $this;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @param string|null $middleInitial
     * @return $this
     */
    public function setMiddleInitial(?string $middleInitial): static
    {
        $this->middleInitial = $middleInitial;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $ssn
     * @return $this
     */
    public function setSsn(string $ssn): static
    {
        $this->ssn = $ssn;
        return $this;
    }

    /**
     * @param DateTimeImmutable|null $dob
     * @return $this
     */
    public function setDob(?DateTimeImmutable $dob): static
    {
        $this->dob = $dob;
        return $this;
    }
}
