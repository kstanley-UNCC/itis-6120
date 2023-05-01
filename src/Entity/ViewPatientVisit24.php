<?php
/** @noinspection PhpUnused */
/** @noinspection PhpPropertyOnlyWrittenInspection */

namespace Itis6120\Project2\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(readOnly: true)]
#[Table(name: "view_patient_visits_24")]
class ViewPatientVisit24 extends AbstractEntity
{
    #[Column(name: "visit_id")]
    #[Id]
    private readonly int $visitId;

    #[Column(name: "patient_honorific", nullable: true)]
    private readonly ?string $patientHonorific;

    #[Column(name: "patient_name")]
    private readonly string $patientName;

    #[Column(name: "patient_email")]
    private readonly string $patientEmail;

    #[Column(name: "patient_dob")]
    private readonly string $patientDob;

    #[Column(name: "patient_ssn")]
    private readonly string $patientSsn;

    #[Column(name: "visit_date_checkin")]
    private readonly string $visitDateCheckin;

    #[Column(name: "visit_date_checkout")]
    private readonly string $visitDateCheckout;

    #[Column(name: "visit_symptoms")]
    private readonly string $visitSymptoms;

    #[Column(name: "visit_discharge", nullable: true)]
    private readonly ?string $visitDischarge;

    #[Column(name: "doctor_honorific", nullable: true)]
    private readonly ?string $doctorHonorific;

    #[Column(name: "doctor_name")]
    private readonly string $doctorName;

    #[Column(name: "doctor_email")]
    private readonly string $doctorEmail;

    #[Column(name: "doctor_title")]
    private readonly string $doctorTitle;

    #[Column(name: "facility_name")]
    private readonly string $facilityName;

    #[Column(name: "facility_phone")]
    private readonly string $facilityPhone;

    #[Column(name: "facility_extension", nullable: true)]
    private readonly ?string $facilityExtension;

    /**
     * @return int
     */
    public function getVisitId(): int
    {
        return $this->visitId;
    }

    /**
     * @return string|null
     */
    public function getPatientHonorific(): ?string
    {
        return $this->patientHonorific;
    }

    /**
     * @return string
     */
    public function getPatientName(): string
    {
        return $this->patientName;
    }

    /**
     * @return string
     */
    public function getPatientEmail(): string
    {
        return $this->patientEmail;
    }

    /**
     * @return string
     */
    public function getPatientDob(): string
    {
        return $this->patientDob;
    }

    /**
     * @return string
     */
    public function getPatientSsn(): string
    {
        return $this->patientSsn;
    }

    /**
     * @return string
     */
    public function getVisitDateCheckin(): string
    {
        return $this->visitDateCheckin;
    }

    /**
     * @return string
     */
    public function getVisitDateCheckout(): string
    {
        return $this->visitDateCheckout;
    }

    /**
     * @return string
     */
    public function getVisitSymptoms(): string
    {
        return $this->visitSymptoms;
    }

    /**
     * @return string|null
     */
    public function getVisitDischarge(): ?string
    {
        return $this->visitDischarge;
    }

    /**
     * @return string|null
     */
    public function getDoctorHonorific(): ?string
    {
        return $this->doctorHonorific;
    }

    /**
     * @return string
     */
    public function getDoctorName(): string
    {
        return $this->doctorName;
    }

    /**
     * @return string
     */
    public function getDoctorEmail(): string
    {
        return $this->doctorEmail;
    }

    /**
     * @return string
     */
    public function getDoctorTitle(): string
    {
        return $this->doctorTitle;
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
    public function getFacilityPhone(): string
    {
        return $this->facilityPhone;
    }

    /**
     * @return string|null
     */
    public function getFacilityExtension(): ?string
    {
        return $this->facilityExtension;
    }
}
