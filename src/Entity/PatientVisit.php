<?php

namespace Itis6120\Project2\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "patient_visits")]
class PatientVisit extends AbstractEntity
{
    #[Column(name: "id", type: "integer")]
    #[Id]
    #[GeneratedValue]
    private int $id;

    #[ManyToOne(targetEntity: Patient::class, cascade: ["persist"], fetch: "EXTRA_LAZY")]
    #[JoinColumn(name: "patient_id", referencedColumnName: "id", nullable: false)]
    private Patient $patient;

    #[ManyToOne(targetEntity: Staffer::class, cascade: ["persist"], fetch: "EXTRA_LAZY")]
    #[JoinColumn(name: "doctor_id", referencedColumnName: "id", nullable: false)]
    private Staffer $doctor;

    #[ManyToOne(targetEntity: Facility::class, fetch: "EXTRA_LAZY")]
    #[JoinColumn(name: "facility_id", referencedColumnName: "id", nullable: false)]
    private Facility $facility;

    #[Column(name: "date_checkin", type: "datetime_immutable")]
    private DateTimeImmutable $dateCheckin;

    #[Column(name: "date_checkout", type: "datetime_immutable", nullable: true, options: ["default" => null])]
    private ?DateTimeImmutable $dateCheckout = null;

    #[Column(name: "symptoms", type: "text")]
    private string $symptoms;

    #[Column(name: "discharge", type: "text")]
    private string $discharge;

    public function __construct()
    {
        $this->dateCheckin = new DateTimeImmutable();
    }

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
     * @return Staffer
     */
    public function getDoctor(): Staffer
    {
        return $this->doctor;
    }

    /**
     * @return Facility
     */
    public function getFacility(): Facility
    {
        return $this->facility;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateCheckin(): DateTimeImmutable
    {
        return $this->dateCheckin;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getDateCheckout(): ?DateTimeImmutable
    {
        return $this->dateCheckout;
    }

    /**
     * @return string
     */
    public function getSymptoms(): string
    {
        return $this->symptoms;
    }

    /**
     * @return string
     */
    public function getDischarge(): string
    {
        return $this->discharge;
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
     * @param Staffer $doctor
     * @return $this
     */
    public function setDoctor(Staffer $doctor): static
    {
        $this->doctor = $doctor;
        return $this;
    }

    /**
     * @param Facility $facility
     * @return $this
     */
    public function setFacility(Facility $facility): static
    {
        $this->facility = $facility;
        return $this;
    }

    /**
     * @param DateTimeImmutable $dateCheckin
     * @return $this
     */
    public function setDateCheckin(DateTimeImmutable $dateCheckin): static
    {
        $this->dateCheckin = $dateCheckin;
        return $this;
    }

    /**
     * @param DateTimeImmutable $dateCheckout
     * @return $this
     */
    public function setDateCheckout(DateTimeImmutable $dateCheckout): static
    {
        $this->dateCheckout = $dateCheckout;
        return $this;
    }

    /**
     * @param string $symptoms
     * @return $this
     */
    public function setSymptoms(string $symptoms): static
    {
        $this->symptoms = $symptoms;
        return $this;
    }

    /**
     * @param string $discharge
     * @return $this
     */
    public function setDischarge(string $discharge): static
    {
        $this->discharge = $discharge;
        return $this;
    }
}
