<?php
/** @noinspection PhpUnused */
/** @noinspection PhpPropertyOnlyWrittenInspection */

namespace Itis6120\Project2\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(readOnly: true)]
#[Table(name: "view_patient_visits_facility")]
class ViewPatientVisitFacility extends AbstractEntity
{
    #[Column(name: "visit_id")]
    #[Id]
    private readonly int $visitId;

    #[Column(name: "patient_name")]
    private readonly string $patientName;

    #[Column(name: "visit_date_checkin")]
    private readonly DateTimeImmutable $visitDateCheckin;

    #[Column(name: "visit_date_checkout")]
    private readonly ?DateTimeImmutable $visitDateCheckout;

    #[Column(name: "facility_name")]
    private readonly string $facilityName;

    #[Column(name: "facility_city")]
    private readonly string $facilityCity;

    #[Column(name: "facility_state")]
    private readonly string $facilityState;

    /**
     * @return int
     */
    public function getVisitId(): int
    {
        return $this->visitId;
    }

    /**
     * @return string
     */
    public function getPatientName(): string
    {
        return $this->patientName;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getVisitDateCheckin(): DateTimeImmutable
    {
        return $this->visitDateCheckin;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getVisitDateCheckout(): ?DateTimeImmutable
    {
        return $this->visitDateCheckout;
    }

    /**
     * @return string
     */
    public function getFacilityName(): string
    {
        return $this->facilityName;
    }

    /**
     * @return string
     */
    public function getFacilityCity(): string
    {
        return $this->facilityCity;
    }

    /**
     * @return string
     */
    public function getFacilityState(): string
    {
        return $this->facilityState;
    }
}
