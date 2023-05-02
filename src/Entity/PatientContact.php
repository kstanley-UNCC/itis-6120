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
#[Table(name: "patient_contacts")]
class PatientContact extends AbstractEntity
{
    #[Column(name: "id", type: "integer")]
    #[Id]
    #[GeneratedValue]
    private int $id;

    #[ManyToOne(targetEntity: Patient::class, cascade: ["persist"], fetch: "EXTRA_LAZY")]
    #[JoinColumn(name: "patient_id", referencedColumnName: "id", nullable: false)]
    private Patient $patient;

    #[Column(name: "name", type: "string", length: 200)]
    private string $name;

    #[Column(name: "phone", type: "string", length: 12)]
    private string $phone;

    #[Column(name: "extension", type: "string", length: 10, nullable: true, options: ["default" => null])]
    private ?string $extension = null;

    #[Column(name: "type", type: "string", length: 8)]
    private string $type;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
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
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string|null $extension
     * @return $this
     */
    public function setExtension(?string $extension): static
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }
}
