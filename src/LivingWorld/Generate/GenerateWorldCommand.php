<?php

namespace LivingWorld\Generate;

use LivingWorld\Generate\XmlFile\WorldStructureGenerator;
use LivingWorld\Generate\XmlFile\XmlFileGetter;
use LivingWorld\Generate\XmlFile\XmlFileSaver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateWorldCommand extends Command
{
    private $worldStructureGenerator;
    private $xmlFileGetter;
    private $xmlFileSaver;

    public function __construct(
        WorldStructureGenerator $worldStructureGenerator,
        XmlFileGetter $xmlFileGetter,
        XmlFileSaver $xmlFileSaver
    ) {
        $this->worldStructureGenerator = $worldStructureGenerator;
        $this->xmlFileGetter = $xmlFileGetter;
        $this->xmlFileSaver = $xmlFileSaver;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('generate:world')
            ->addArgument('targetFileName', InputArgument::REQUIRED, 'Target XML file name.')
            ->addArgument('speciesCount', InputArgument::REQUIRED, 'Number of species present in the new world.')
            ->addArgument('cellsCount', InputArgument::REQUIRED, 'Number of cells representing the new world.')
            ->addArgument('iterationsCount', InputArgument::REQUIRED, 'Number of iterations to be executed.')
            ->setDescription('Generates initial XML data file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start generating into target file: '.$input->getArgument('targetFileName'));

        $numberOfCells = (int) $input->getArgument('cellsCount');
        $numberOfSpecies = (int) $input->getArgument('speciesCount');
        $numberOfIterations = (int) $input->getArgument('iterationsCount');
        $this->validateInput($numberOfCells, $numberOfSpecies, $numberOfIterations);

        $worldStructure = $this->worldStructureGenerator->generateWorldStructure($numberOfCells, $numberOfSpecies, $numberOfIterations);
        $xmlFileContents = $this->xmlFileGetter->getXmlFile($worldStructure);

        $this->xmlFileSaver->saveXmlFile($input->getArgument('targetFileName'), $xmlFileContents);
    }

    private function validateInput(int $numberOfCells, int $numberOfSpecies, int $numberOfIterations)
    {
        if ($numberOfSpecies < 3) {
            throw new InvalidArgumentException('Cannot generate world: number of species too low, at least 3 expected');
        }
        if ($numberOfCells < 3) {
            throw new InvalidArgumentException('Cannot generate world: number of cells too low, at least 3 expected');
        }
        if ($numberOfIterations < 10) {
            throw new InvalidArgumentException('Cannot generate world: number of iterations too low, at least 10 expected');
        }
        if (($numberOfCells * $numberOfCells) < $numberOfSpecies) {
            throw new InvalidArgumentException(
                sprintf(
                    'Cannot generate world: %d species will not fit into available cells: %d',
                    $numberOfSpecies,
                    $numberOfCells * $numberOfCells
                )
            );
        }
    }
}
