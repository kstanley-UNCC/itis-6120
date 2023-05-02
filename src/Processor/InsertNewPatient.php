<?php

namespace Itis6120\Project2\Processor;

use DateTimeImmutable;
use Itis6120\Project2\ChoiceProcessor;
use Itis6120\Project2\Entity\Patient;
use Itis6120\Project2\Entity\PatientAddress;
use Itis6120\Project2\Entity\PatientContact;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

readonly final class InsertNewPatient extends AbstractProcessor
{
    public function __construct(ChoiceProcessor $visitor)
    {
        parent::__construct($visitor, Patient::class);
    }

    public function process(): array
    {
        $em = $this->getEntityManager();
        $patient = $em->wrapInTransaction(function() {
            $this->getOutput()->clear();

            $patient = $this->createPatient();
            $this->getOutput()->clear();

            $this->createPatientAddress($patient);
            $this->getOutput()->clear();

            $this->createPatientContact($patient);
            $this->getOutput()->clear();

            return $patient;
        });

        // Return new patient record
        return [$patient];
    }

    private function createPatient(): Patient
    {
        $entity = new Patient();
        $entity
            ->setFirstName($this->askQuestion(
                (new Question('First Name: '))
                    ->setNormalizer(static fn(string $input): string => ucwords(strtolower($input)))
            ))
            ->setLastName($this->askQuestion(
                (new Question('Last Name: '))
                    ->setNormalizer(static fn(string $input): string => ucwords(strtolower($input)))
            ))
            ->setMiddleInitial($this->askQuestion(
                (new Question('Middle Initial (Enter to skip): '))
                    ->setNormalizer(static function(?string $input): ?string {
                        return $input !== null
                            ? strtoupper($input)
                            : $input;
                    })
            ))
            ->setHonorific($this->askQuestion(
                (new Question('Honorific (Enter to skip): '))
                    ->setNormalizer(static function(?string $input): ?string {
                        return $input !== null
                            ? ucwords(strtolower($input))
                            : $input;
                    })
            ))
            ->setEmail($this->askQuestion((new Question('Email: '))))
            ->setGender($this->askQuestion(
                (new Question('Gender [M/F]: '))
                    ->setNormalizer(static fn(string $input): string => strtoupper($input))
            ))
            ->setSsn($this->askQuestion(
                (new Question('SSN: '))
                    ->setNormalizer(static function(string $input): string {
                        $input = preg_replace('/[^0-9]+/', '', $input);
                        return preg_replace('/([0-9]{3})([0-9]{2})([0-9]{4})/', '$1-$2-$3', $input);
                    })
            ))
            ->setDob($this->askQuestion(
                (new Question('Date of Birth (mm/dd/YYYY): '))
                    ->setNormalizer(static fn(string $input): DateTimeImmutable => DateTimeImmutable::createFromFormat('m/d/Y|', $input))
            ));

        $em = $this->getEntityManager();
        $em->persist($entity);

        return $entity;
    }

    private function createPatientAddress(Patient $patient): void
    {
        while (true) {
            if (!$this->askQuestion(new ConfirmationQuestion('Do you wish to add an address? '))) {
                return;
            }

            $entity = new PatientAddress();
            $entity->setPatient($patient);

            $entity
                ->setStreet($this->askQuestion(
                    (new Question('Street 1: '))
                        ->setNormalizer(static fn(string $input): string => ucwords(strtolower($input)))
                ))
                ->setStreet2($this->askQuestion(
                    (new Question('Street 2 (Enter to skip): '))
                        ->setNormalizer(static function (?string $input): ?string {
                            return $input !== null
                                ? ucwords(strtolower($input))
                                : $input;
                        })
                ))
                ->setStreet3($this->askQuestion(
                    (new Question('Street 3 (Enter to skip): '))
                        ->setNormalizer(static function (?string $input): ?string {
                            return $input !== null
                                ? ucwords(strtolower($input))
                                : $input;
                        })
                ))
                ->setCity($this->askQuestion(
                    (new Question('City: '))
                        ->setNormalizer(static fn(string $input): string => ucwords(strtolower($input)))
                ))
                ->setState($this->askQuestion(
                    (new Question('State: '))
                        ->setNormalizer(static fn(string $input): string => strtoupper($input))
                ))
                ->setZip($this->askQuestion(
                    (new Question('Zip: '))
                        // Because other countries can use letters.
                        ->setNormalizer(static fn(string $input): string => strtoupper($input))
                ));

            $em = $this->getEntityManager();
            $em->persist($entity);
        }
    }

    public function createPatientContact(Patient $patient): void
    {
        while (true) {
            if (!$this->askQuestion(new ConfirmationQuestion('Do you wish to add a new contact? '))) {
                return;
            }

            $entity = new PatientContact();
            $entity->setPatient($patient);

            $entity
                ->setName($this->askQuestion(
                    (new Question('Name: '))
                        ->setNormalizer(static fn(string $input): string => ucwords(strtolower($input)))
                ))
                ->setPhone($this->askQuestion(
                    (new Question('Phone: '))
                    ->setNormalizer(static function(string $input): string {
                        $input = ltrim(preg_replace('/\D+/', '', $input), '+');

                        if ($input[0] === 1) {
                            $input = substr($input, 1, strlen($input));
                        }

                        return preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $input);
                    })
                ))
                ->setType($this->askQuestion(
                    (new Question('Type [(S)elf, Spo(u)se, (P)arent, (G)uardian, (O)ther]: '))
                        ->setNormalizer(static function(string $input): string {
                            return match (strtoupper($input)) {
                                'S' => 'SELF',
                                'U' => 'SPOUSE',
                                'P' => 'PARENT',
                                'G' => 'GUARDIAN',
                                default => 'OTHER',
                            };
                        })
                ));

            $em = $this->getEntityManager();
            $em->persist($entity);
        }
    }
}
