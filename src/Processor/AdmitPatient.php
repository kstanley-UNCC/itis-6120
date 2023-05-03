<?php

namespace Itis6120\Project2\Processor;

use Itis6120\Project2\ChoiceProcessor;
use Itis6120\Project2\Entity\Facility;
use Itis6120\Project2\Entity\Patient;
use Itis6120\Project2\Entity\PatientVisit;
use Itis6120\Project2\Entity\Staffer;
use Symfony\Component\Console\Question\Question;

readonly final class AdmitPatient extends AbstractProcessor
{
    public function __construct(ChoiceProcessor $visitor)
    {
        parent::__construct($visitor, PatientVisit::class);
    }

    public function process(): array
    {
        $em = $this->getEntityManager();
        $visit = $em->wrapInTransaction(function() {
            $this->getOutput()->clear();

            $visit = new PatientVisit();
            $visit->setFacility($this->askFacility());
            $visit->setDoctor($this->askDoctor());
            $visit->setPatient($this->askPatient());
            $visit->setSymptoms($this->askSymptoms());

            $this->getEntityManager()->persist($visit);
            $this->getEntityManager()->flush();

            return $visit;
        });

        return [$visit];
    }

    private function askFacility(): Facility
    {
        $facility = null;

        while ($facility === null) {
            $facilityRepo = $this->getRepository(Facility::class);

            $facilities = $facilityRepo->findBy([], ['name' => 'ASC']);
            $facilities = array_map(static fn(Facility $facility): string => $facility->getName(), $facilities);

            $facility = $facilityRepo->findOneBy(['name' => $this->autocomplete('Facility Name', $facilities)]);

            if ($facility === null) {
                $this->askQuestion(new Question('Invalid facility. Press enter to try again...'));
                $this->getOutput()->clear(4);
            }
        }

        return $facility;
    }

    private function askDoctor(): Staffer
    {
        $doctor = null;

        while ($doctor === null) {
            $doctorRepo = $this->getRepository(Staffer::class);

            $staff = $doctorRepo->findBy([], ['lastName' => 'ASC', 'firstName' => 'ASC']);
            $staff = array_map(static fn(Staffer $doctor): string => sprintf('%s %s', $doctor->getFirstName(), $doctor->getLastName()), $staff);

            @[$firstName, $lastName] = @explode(' ', $this->autocomplete('Doctor Name', $staff), 2);
            $doctor = $doctorRepo->findOneBy(['firstName' => $firstName, 'lastName' => $lastName]);

            if ($doctor === null) {
                $this->askQuestion(new Question('Invalid doctor. Press enter to try again...'));
                $this->getOutput()->clear(4);
            }
        }

        return $doctor;
    }

    private function askPatient(): Patient
    {
        $patient = null;

        while ($patient === null) {
            $patientRepo = $this->getRepository(Patient::class);

            $staff = $patientRepo->findBy([], ['lastName' => 'ASC', 'firstName' => 'ASC']);
            $staff = array_map(static fn(Patient $patient): string => sprintf('%s %s [%s]', $patient->getFirstName(), $patient->getLastName(), $patient->getEmail()), $staff);

            @[$firstName, $lastName, $email] = sscanf($this->autocomplete('Patient Name', $staff), '%s %s [%[^]]]');
            $patient = $patientRepo->findOneBy(['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email]);

            if ($patient === null) {
                $this->askQuestion(new Question('Invalid patient. Press enter to try again...'));
                $this->getOutput()->clear(4);
            }
        }

        return $patient;
    }

    private function askSymptoms(): string
    {
        $question = new Question('Symptoms (Ctrl-D to end): ');
        $question->setMultiline(true);

        return $this->askQuestion($question);
    }
}
