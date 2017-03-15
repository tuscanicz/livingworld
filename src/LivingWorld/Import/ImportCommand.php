<?php

namespace LivingWorld\Import;

use LivingWorld\Generate\XmlFile\XmlFileGetter;
use LivingWorld\Generate\XmlFile\XmlFileSaver;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\OrganismOutputFormatter;
use LivingWorld\Graphics\Screen\ScreenWriter;
use LivingWorld\Import\Processor\ImportFileProcessor;
use LivingWorld\Import\XmlFile\Output\WorldStructureGetter;
use LivingWorld\Import\XmlFile\XmlFileParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    private $organismOutputFormatter;
    private $xmlFileParser;
    private $importFileProcessor;
    private $worldStructureGetter;
    private $xmlFileGetter;
    private $xmlFileSaver;
    private $screenWriter;

    public function __construct(
        OrganismOutputFormatter $organismOutputFormatter,
        XmlFileParser $xmlFileParser,
        ImportFileProcessor $importFileProcessor,
        WorldStructureGetter $worldStructureGetter,
        XmlFileGetter $xmlFileGetter,
        XmlFileSaver $xmlFileSaver,
        ScreenWriter $screenWriter
    ) {
        $this->organismOutputFormatter = $organismOutputFormatter;
        $this->xmlFileParser = $xmlFileParser;
        $this->importFileProcessor = $importFileProcessor;
        $this->worldStructureGetter = $worldStructureGetter;
        $this->xmlFileGetter = $xmlFileGetter;
        $this->xmlFileSaver = $xmlFileSaver;
        $this->screenWriter = $screenWriter;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('import:xml')
            ->addArgument('sourceFile', InputArgument::REQUIRED, 'The source XML file to import.')
            ->addArgument('targetFileName', InputArgument::REQUIRED, 'Target XML file name.')
            ->setDescription('Executes a initial data import from given XML file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->organismOutputFormatter->formatOutput($output);
        $output->writeln('Start import from sourceFile: '.$input->getArgument('sourceFile'));

        $firstFrame = $this->xmlFileParser->parseXmlFile($input->getArgument('sourceFile'));
        $frames = $this->getFrames($firstFrame);
        $lastFrame = end($frames);

        $this->writeLastFrameIntoFile($lastFrame, $input->getArgument('targetFileName'));
        $this->screenWriter->writeScreen($frames, $output, ScreenWriter::DEFAULT_FPS);
    }

    private function getFrames(Frame $frame)
    {
        $frames = [];
        do {
            $frame = $this->importFileProcessor->process($frame);
            $frames[] = $frame;
        } while ($frame->getRemainingFrames() > 1);

        return $frames;
    }

    private function writeLastFrameIntoFile(Frame $lastFrame, string $targetFileName)
    {
        $worldStructure = $this->worldStructureGetter->getWordStructureFromFrame($lastFrame);
        $xmlFileContents = $this->xmlFileGetter->getXmlFile($worldStructure);
        $this->xmlFileSaver->saveXmlFile($targetFileName, $xmlFileContents);
    }
}
