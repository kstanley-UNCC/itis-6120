<?php

namespace Itis6120\Project2;

use Doctrine\ORM\EntityManager;
use Itis6120\Project2\Entity\AbstractEntity;
use Itis6120\Project2\Processor\AdmittedByDoctor;
use Itis6120\Project2\Processor\AdmittedByFacility;
use Itis6120\Project2\Processor\AdmittedToday;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UnexpectedValueException;

final readonly class ChoiceProcessor
{
    private const CHOICE_ADMIT_PATIENT = 'Admit Patient';
    private const CHOICE_ADMIT_TODAY = 'Patients Admitted Today';
    private const CHOICE_DOCTOR = 'Patients by Doctor';
    private const CHOICE_FACILITY = 'Patients by Facility';
    private const CHOICE_NEW_PATIENT = 'Add New Patient';
    private const CHOICE_NEW_STAFFER = 'Add New Staffer';

    public function __construct(
        public EntityManager $em,
        public InputInterface $input,
        public OutputInterface $output,
        public QuestionHelper $helper,
    ) {
    }

    public function getChoices(): array
    {
        return [
            self::CHOICE_ADMIT_TODAY,
            self::CHOICE_FACILITY,
            self::CHOICE_DOCTOR,
            self::CHOICE_NEW_PATIENT,
            self::CHOICE_NEW_STAFFER,
            self::CHOICE_ADMIT_PATIENT,
        ];
    }

    public function process(string $choice): array
    {
        switch ($choice) {
            case self::CHOICE_ADMIT_TODAY:
                $processor = new AdmittedToday($this);
                break;
            case self::CHOICE_FACILITY:
                $processor = new AdmittedByFacility($this);
                break;
            case self::CHOICE_DOCTOR:
                $processor = new AdmittedByDoctor($this);
                break;
            case self::CHOICE_NEW_PATIENT:
                break;
            case self::CHOICE_NEW_STAFFER:
                break;
            case self::CHOICE_ADMIT_PATIENT:
                break;
            default:
                throw new UnexpectedValueException(sprintf('%s: Invalid choice selected', $choice));
        }

        /** @var AbstractEntity $class */
        $class = $processor->getEntityClass();
        $results = $processor->process();

        return [
            'count' => count($results),
            'headers' => $class::getFields(),
            'rows' => array_map(static function(AbstractEntity $entity): array {
                return $entity->toArray();
            }, $results),
        ];
    }
}
