<?php

namespace Itis6120\Project2\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "patient_addresses")]
class PatientAddress extends AbstractEntity
{
    #[Column(name: "id", type: "integer")]
    #[Id]
    #[GeneratedValue]
    private int $id;

    #[ManyToOne(targetEntity: Patient::class, cascade: ["persist"], fetch: "EXTRA_LAZY")]
    #[JoinColumn(name: "patient_id", referencedColumnName: "id", nullable: false)]
    private Patient $patient;

    #[Column(name: "street", type: "string", length: 150)]
    private string $street;

    #[Column(name: "street2", type: "string", length: 150, nullable: true, options: ["default" => null])]
    private ?string $street2 = null;

    #[Column(name: "street3", type: "string", length: 150, nullable: true, options: ["default" => null])]
    private ?string $street3 = null;

    #[Column(name: "city", type: "string", length: 100)]
    private string $city;

    #[Column(name: "state", type: "string", length: 2)]
    private string $state;

    #[Column(name: "zip", type: "string", length: 10)]
    private string $zip;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Patient
     */
    public function getPatient(): Patient
    {
        return $this->patient;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string|null
     */
    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    /**
     * @return string|null
     */
    public function getStreet3(): ?string
    {
        return $this->street3;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
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
     * @param Patient $patient
     * @return $this
     */
    public function setPatient(Patient $patient): static
    {
        $this->patient = $patient;
        return $this;
    }

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet(string $street): static
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @param string|null $street2
     * @return $this
     */
    public function setStreet2(?string $street2): static
    {
        $this->street2 = $street2;
        return $this;
    }

    /**
     * @param string|null $street3
     * @return $this
     */
    public function setStreet3(?string $street3): static
    {
        $this->street3 = $street3;
        return $this;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): static
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param string $state
     * @return $this
     */
    public function setState(string $state): static
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param string $zip
     * @return $this
     */
    public function setZip(string $zip): static
    {
        $this->zip = $zip;
        return $this;
    }
}
