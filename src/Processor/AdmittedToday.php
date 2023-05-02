<?php

namespace Itis6120\Project2\Processor;

use Itis6120\Project2\ChoiceProcessor;
use Itis6120\Project2\Entity\ViewPatientVisit24;

readonly final class AdmittedToday extends AbstractProcessor
{
    public function __construct(ChoiceProcessor $visitor)
    {
        parent::__construct($visitor, ViewPatientVisit24::class);
    }

    public function process(): array
    {
        return $this->getRepository()->findAll();
    }
}
