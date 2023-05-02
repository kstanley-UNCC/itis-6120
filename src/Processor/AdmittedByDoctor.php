<?php

namespace Itis6120\Project2\Processor;

use Itis6120\Project2\ChoiceProcessor;
use Itis6120\Project2\Entity\Staffer;
use Itis6120\Project2\Entity\ViewPatientVisitDoctor;

readonly final class AdmittedByDoctor extends AbstractProcessor
{
    public function __construct(ChoiceProcessor $visitor)
    {
        parent::__construct($visitor, ViewPatientVisitDoctor::class);
    }

    public function process(): array
    {
        $staffRepo = $this->getRepository(Staffer::class);

        $staff = array_values(array_filter(
            $staffRepo->findBy([], ['lastName' => 'ASC', 'firstName' => 'ASC']),
            static fn(Staffer $staffer): bool => $staffer->hasVisits()
        ));

        $staff = array_map(
            static fn(Staffer $staffer): string => sprintf('%s, %s', $staffer->getLastName(), $staffer->getFirstName()),
            $staff
        );

        $staffer = $this->autocomplete('Doctor Name', $staff);
        return $this->getRepository()->findBy(['doctorName' => $staffer], ['patientName' => 'asc']);    }
}
