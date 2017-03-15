<?php

namespace LivingWorld\Import\Processor;

use LivingWorld\Entity\Organism;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Logger\ImportProcessorLogger;

class ImportFileProcessor
{
    private $logger;

    public function __construct(ImportProcessorLogger $logger)
    {
        $this->logger = $logger;
    }

    public function process(Frame $frame)
    {
        return new Frame(
            $frame->getGrid(),
            $this->processLifeCycle($frame),
            $frame->getRemainingFrames() - 1,
            $frame->getFrameNumber() + 1
        );
    }

    /**
     * @param Frame $previousFrame
     * @return Organism[]
     */
    private function processLifeCycle(Frame $previousFrame)
    {
        $survivingOrganisms = [];
        if ($previousFrame->hasOrganisms() === true) {
            // @todo: refactor this mess
            for ($x = 0; $x < $previousFrame->getGrid()->getSize(); $x++) {
                for ($y = 0; $y < $previousFrame->getGrid()->getSize(); $y++) {
                    if ($previousFrame->isPositionEmpty($x, $y)) {
                        $numberOfNeighbours = $previousFrame->getNumberOfSameTypeNeighbours($x, $y);
                        $this->logger->logOperation('position empty', $x, $y, $numberOfNeighbours, $previousFrame);
                        if ($numberOfNeighbours === 3) {
                            // give a BIRTH
                            // @todo: get type of the new organism
                            $survivingOrganisms[] = new Organism($x, $y, OrganismTypeEnum::TYPE_HARKONNEN);
                            $this->logger->logOperation('creating a new organism', $x, $y, $numberOfNeighbours, $previousFrame);
                        }
                    } else {
                        $numberOfNeighbours = $previousFrame->getNumberOfSameTypeNeighbours($x, $y);
                        $this->logger->logOperation('neighbours found', $x, $y, $numberOfNeighbours, $previousFrame);
                        if ($numberOfNeighbours >= 4 || $numberOfNeighbours < 2) {
                            $this->logger->logOperation('dying organism', $x, $y, $numberOfNeighbours, $previousFrame);
                        } else {
                            $survivingOrganisms[] = clone $previousFrame->getPosition($x, $y);
                            $this->logger->logOperation('a new clone', $x, $y, $numberOfNeighbours, $previousFrame);
                        }
                    }
                }
            }
        }

        return $survivingOrganisms;
    }
}
