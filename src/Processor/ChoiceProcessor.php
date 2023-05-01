<?php

namespace Itis6120\Project2\Processor;

use Doctrine\ORM\EntityManager;
use Itis6120\Project2\Entity\AbstractEntity;
use Itis6120\Project2\Entity\Facility;
use Itis6120\Project2\Entity\Staffer;
use Itis6120\Project2\Entity\ViewPatientVisit24;
use Itis6120\Project2\Entity\ViewPatientVisitDoctor;
use Itis6120\Project2\Entity\ViewPatientVisitFacility;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use UnexpectedValueException;

final class ChoiceProcessor
{
    private const CHOICE_ADMIT_TODAY = 'Patients Admitted Today';
    private const CHOICE_FACILITY = 'Patients by Facility';
    private const CHOICE_DOCTOR = 'Patients by Doctor';
    private const CHOICE_NEW_PATIENT = 'Add New Patient';
    private const CHOICE_NEW_STAFFER = 'Add New Staffer';
    private const CHOICE_ADMIT_PATIENT = 'Admit Patient';

    public function __construct(
        private readonly EntityManager $em,
        private readonly InputInterface $input,
        private readonly OutputInterface $output,
        private readonly QuestionHelper $helper,
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
                $repo = $this->em->getRepository(ViewPatientVisit24::class);
                $results = $repo->findAll();
                break;
            case self::CHOICE_FACILITY:
                $repo = $this->em->getRepository(Facility::class);
                $facilities = array_values(array_filter($repo->findBy([], ['name' => 'ASC']), static fn(Facility $facility): bool => $facility->hasVisits()));
                $facilities = array_map(static fn(Facility $facility): string => $facility->getName(), $facilities);

                $facility = $this->askAutocomplete('Facility Name', $facilities);

                $repo = $this->em->getRepository(ViewPatientVisitFacility::class);
                $results = $repo->findBy(['facilityName' => $facility], ['patientName' => 'asc']);
                break;
            case self::CHOICE_DOCTOR:
                $repo = $this->em->getRepository(Staffer::class);
                $staff = array_values(array_filter($repo->findBy([], ['lastName' => 'ASC', 'firstName' => 'ASC']), static fn(Staffer $staffer): bool => $staffer->hasVisits()));
                $staff = array_map(static fn(Staffer $staffer): string => sprintf('%s, %s', $staffer->getLastName(), $staffer->getFirstName()), $staff);

                $staffer = $this->askAutocomplete('Doctor Name', $staff);

                $repo = $this->em->getRepository(ViewPatientVisitDoctor::class);
                $results = $repo->findBy(['doctorName' => $staffer], ['patientName' => 'asc']);
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
        $class = $repo->createResultSetMappingBuilder('class')->getClassName('class');

        return [
            'count' => count($results),
            'headers' => $class::getFields(),
            'rows' => array_map(static function(AbstractEntity $entity): array {
                return $entity->toArray();
            }, $results),
        ];
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param QuestionHelper $helper
     * @param string $label
     * @param array $choices
     * @return string|null
     */
    private function askAutocomplete(string $label, array $choices): ?string
    {
        $question = new Question(sprintf('%s (↑/↓): ', $label));
        $question
            ->setTrimmable(true)
            ->setMultiline(false)
            ->setAutocompleterCallback(static function(string $input) use ($choices): array {
                return array_values(array_filter($choices, static fn(string $choice): bool => str_starts_with($choice, $input)));
            });

        return $this->helper->ask($this->input, $this->output, $question);
    }
}
