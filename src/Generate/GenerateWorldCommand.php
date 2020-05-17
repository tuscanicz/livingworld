<?php

declare(strict_types = 1);

namespace LivingWorld\Generate;

use LivingWorld\Command\Argument\CommandArgumentGetter;
use LivingWorld\Command\Result\CommandResultEnum;
use LivingWorld\File\FileWriter;
use LivingWorld\Generate\XmlFile\WorldStructureGenerator;
use LivingWorld\Generate\XmlFile\XmlFileGetter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateWorldCommand extends Command
{

    private CommandArgumentGetter $commandArgumentGetter;
    private WorldStructureGenerator $worldStructureGenerator;
    private XmlFileGetter $xmlFileGetter;
    private FileWriter $fileWriter;

    public function __construct(
        CommandArgumentGetter $commandArgumentGetter,
        WorldStructureGenerator $worldStructureGenerator,
        XmlFileGetter $xmlFileGetter,
        FileWriter $fileWriter
    ) {
        $this->commandArgumentGetter = $commandArgumentGetter;
        $this->worldStructureGenerator = $worldStructureGenerator;
        $this->xmlFileGetter = $xmlFileGetter;
        $this->fileWriter = $fileWriter;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('generate:world')
            ->addArgument('targetFileName', InputArgument::REQUIRED, 'Target XML file name.')
            ->addArgument('speciesCount', InputArgument::REQUIRED, 'Number of species present in the new world.')
            ->addArgument('cellsCount', InputArgument::REQUIRED, 'Number of cells representing the new world.')
            ->addArgument('iterationsCount', InputArgument::REQUIRED, 'Number of iterations to be executed.')
            ->setDescription('Generates initial XML data file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $targetFile = $this->commandArgumentGetter->getStringArgument($input, 'targetFileName');
        $numberOfCells = $this->commandArgumentGetter->getIntegerArgument($input, 'cellsCount');
        $numberOfSpecies = $this->commandArgumentGetter->getIntegerArgument($input, 'speciesCount');
        $numberOfIterations = $this->commandArgumentGetter->getIntegerArgument($input, 'iterationsCount');
        $this->validateInput($numberOfCells, $numberOfSpecies, $numberOfIterations);

        $output->writeln('Start generating world into target file: '.$targetFile);
        $worldStructure = $this->worldStructureGenerator->generateWorldStructure($numberOfCells, $numberOfSpecies, $numberOfIterations);
        $xmlFileContents = $this->xmlFileGetter->getXmlFile($worldStructure);

        $this->fileWriter->writeFile($targetFile, $xmlFileContents);
        
        $output->writeln('World generated successfully.');

        return CommandResultEnum::RESULT_SUCCESS;
    }

    private function validateInput(int $numberOfCells, int $numberOfSpecies, int $numberOfIterations): void
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
