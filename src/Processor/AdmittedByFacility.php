<?php

namespace Itis6120\Project2\Processor;

use Itis6120\Project2\ChoiceProcessor;
use Itis6120\Project2\Entity\Facility;
use Itis6120\Project2\Entity\ViewPatientVisitFacility;

readonly final class AdmittedByFacility extends AbstractProcessor
{
    public function __construct(ChoiceProcessor $visitor)
    {
        parent::__construct($visitor, ViewPatientVisitFacility::class);
    }

    public function process(): array
    {
        $facilityRepo = $this->getRepository(Facility::class);

        $facilities = array_values(array_filter($facilityRepo->findBy([], ['name' => 'ASC']), static fn(Facility $facility): bool => $facility->hasVisits()));
        $facilities = array_map(static fn(Facility $facility): string => $facility->getName(), $facilities);

        $facility = $this->autocomplete('Facility Name', $facilities);
        return $this->getRepository()->findBy(['facilityName' => $facility], ['patientName' => 'asc']);
    }
}
