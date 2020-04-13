<?php

declare(strict_types = 1);

namespace LivingWorld\Import;

use LivingWorld\Command\Argument\CommandArgumentGetter;
use LivingWorld\Command\Result\CommandResultEnum;
use LivingWorld\Graphics\OrganismOutputFormatter;
use LivingWorld\Graphics\Screen\FramePerSecondsEnum;
use LivingWorld\Graphics\Screen\ScreenWriter;
use LivingWorld\Import\XmlFile\XmlFileParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{

    private CommandArgumentGetter $commandArgumentGetter;
    private OrganismOutputFormatter $organismOutputFormatter;
    private XmlFileParser $xmlFileParser;
    private ScreenWriter $screenWriter;
    private ImportCommandFacade $importCommandFacade;

    public function __construct(
        CommandArgumentGetter $commandArgumentGetter,
        OrganismOutputFormatter $organismOutputFormatter,
        XmlFileParser $xmlFileParser,
        ScreenWriter $screenWriter,
        ImportCommandFacade $importCommandFacade
    ) {
        $this->commandArgumentGetter = $commandArgumentGetter;
        $this->organismOutputFormatter = $organismOutputFormatter;
        $this->xmlFileParser = $xmlFileParser;
        $this->screenWriter = $screenWriter;
        $this->importCommandFacade = $importCommandFacade;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('import:xml')
            ->addArgument('sourceFile', InputArgument::REQUIRED, 'The source XML file to import.')
            ->addArgument('targetFileName', InputArgument::REQUIRED, 'Target XML file name.')
            ->addArgument('fps', InputArgument::REQUIRED, 'Frames per second.')
            ->setDescription('Executes a initial data import from given XML file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sourceFile = $this->commandArgumentGetter->getStringArgument($input, 'sourceFile');
        $targetFileName = $this->commandArgumentGetter->getStringArgument($input, 'targetFileName');
        $fps = $this->commandArgumentGetter->getIntegerArgument($input, 'fps');

        $this->organismOutputFormatter->formatOutput($output);
        $output->writeln('Start import from sourceFile: '.$sourceFile);

        $firstFrame = $this->xmlFileParser->parseXmlFile($sourceFile);
        $frames = $this->importCommandFacade->getProcessedFrames($firstFrame);

        $this->importCommandFacade->writeLastFrameIntoFile($frames->getLastFrame(), $targetFileName);
        $this->screenWriter->writeScreen($frames, $output, $this->getFrameRate($fps));

        return CommandResultEnum::RESULT_SUCCESS;
    }

    private function getFrameRate(int $fps): FramePerSecondsEnum
    {
        try {
            return new FramePerSecondsEnum($fps);
        } catch (\InvalidArgumentException $e) {
            throw new \Exception(
                sprintf(
                    'Could not play designated frame rate of %d fps, allowed rates are: %s',
                    $fps,
                    implode(', ', FramePerSecondsEnum::getValues())
                )
            );
        }
    }

}
