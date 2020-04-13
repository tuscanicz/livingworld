<?php

declare(strict_types = 1);

namespace LivingWorld\Import;

use LivingWorld\File\FileWriter;
use LivingWorld\Generate\XmlFile\XmlFileGetter;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\Frame\FrameList;
use LivingWorld\Import\Processor\ImportFileProcessor;
use LivingWorld\Import\XmlFile\Output\WorldStructureGetter;

class ImportCommandFacade
{

    private ImportFileProcessor $importFileProcessor;
    private WorldStructureGetter $worldStructureGetter;
    private XmlFileGetter $xmlFileGetter;
    private FileWriter $fileWriter;

    public function __construct(
        ImportFileProcessor $importFileProcessor,
        WorldStructureGetter $worldStructureGetter,
        XmlFileGetter $xmlFileGetter,
        FileWriter $fileWriter
    ) {
        $this->importFileProcessor = $importFileProcessor;
        $this->worldStructureGetter = $worldStructureGetter;
        $this->xmlFileGetter = $xmlFileGetter;
        $this->fileWriter = $fileWriter;
    }

    public function getProcessedFrames(Frame $frame): FrameList
    {
        $frames = [];
        do {
            $frame = $this->importFileProcessor->processFrame($frame);
            $frames[] = $frame;
        } while ($frame->getRemainingFrames() > 1);

        return new FrameList($frames);
    }

    public function writeLastFrameIntoFile(Frame $lastFrame, string $targetFileName): void
    {
        $worldStructure = $this->worldStructureGetter->getWordStructureFromFrame($lastFrame);
        $xmlFileContents = $this->xmlFileGetter->getXmlFile($worldStructure);
        $this->fileWriter->writeFile($targetFileName, $xmlFileContents);
    }

}
