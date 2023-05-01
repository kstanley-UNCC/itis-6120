<?php

namespace Itis6120\Project2\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "facilities")]
class Facility extends AbstractEntity
{
    #[Column(name: "id", type: "integer")]
    #[Id]
    private int $id;

    #[Column(name: "facility_name", type: "string", length: 255)]
    private string $name;

    #[Column(name: "address1", type: "string", length: 255)]
    private string $address1;

    #[Column(name: "address2", type: "string", length: 255, nullable: true, options: ["default" => null])]
    private ?string $address2 = null;

    #[Column(name: "address3", type: "string", length: 255, nullable: true, options: ["default" => null])]
    private ?string $address3 = null;

    #[Column(name: "city", type: "string", length: 150)]
    private string $city;

    #[Column(name: "state", type: "string", length: 2)]
    private string $state;

    #[Column(name: "zip", type: "string", length: 5)]
    private string $zip;

    #[Column(name: "phone", type: "string", length: 10)]
    private string $phone;

    #[Column(name: "extension", type: "string", length: 5, nullable: true, options: ["default" => true])]
    private ?string $extension = null;

    #[Column(name: "fax", type: "string", length: 10, nullable: true, options: ["default" => true])]
    private ?string $fax = null;

    #[OneToMany(mappedBy: "facility", targetEntity: PatientVisit::class, fetch: "EXTRA_LAZY")]
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddress1(): string
    {
        return $this->address1;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @return string|null
     */
    public function getAddress3(): ?string
    {
        return $this->address3;
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
     * @return string|null
     */
    public function getFax(): ?string
    {
        return $this->fax;
    }

    /**
     * @return Collection
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    /**
     * @return bool
     */
    public function hasVisits(): bool
    {
        return $this->getVisits()->count() > 0;
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
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $address1
     * @return $this
     */
    public function setAddress1(string $address1): static
    {
        $this->address1 = $address1;
        return $this;
    }

    /**
     * @param string|null $address2
     * @return $this
     */
    public function setAddress2(?string $address2): static
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @param string|null $address3
     * @return $this
     */
    public function setAddress3(?string $address3): static
    {
        $this->address3 = $address3;
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
     * @param string|null $fax
     * @return $this
     */
    public function setFax(?string $fax): static
    {
        $this->fax = $fax;
        return $this;
    }
}
