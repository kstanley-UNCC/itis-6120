<?php

namespace Itis6120\Project2\Processor;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\Persistence\ObjectRepository;
use Itis6120\Project2\ChoiceProcessor;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

abstract readonly class AbstractProcessor implements ProcessorInterface
{
    public function __construct(protected ChoiceProcessor $visitor, protected string $className)
    {
    }

    public function askQuestion(Question $question): mixed
    {
        return $this->getHelper()->ask($this->getInput(), $this->getOutput(), $question);
    }

    public function autocomplete(string $label, array $choices): mixed
    {
        $question = new Question(sprintf('%s (↑/↓): ', $label));
        $question
            ->setTrimmable(true)
            ->setMultiline(false)
            ->setAutocompleterCallback(static function(string $input) use ($choices): array {
                return array_values(array_filter($choices, static fn(string $choice): bool => str_starts_with($choice, $input)));
            });

        return $this->askQuestion($question);
    }

    public function getEntityClass(): string
    {
        return $this->getRepository()->createResultSetMappingBuilder('class')->getClassName('class');
    }

    public function getEntityManager(): EntityManager
    {
        return $this->visitor->em;
    }

    public function getHelper(): HelperInterface
    {
        return $this->visitor->helper;
    }

    public function getInput(): InputInterface
    {
        return $this->visitor->input;
    }

    public function getOutput(): OutputInterface
    {
        return $this->visitor->output;
    }

    /**
     * @param string $className
     * @return EntityRepository|ObjectRepository
     * @throws NotSupported
     */
    public function getRepository(string $className = null): EntityRepository|ObjectRepository
    {
        return $this->visitor->em->getRepository($className ?? $this->className);
    }
}
