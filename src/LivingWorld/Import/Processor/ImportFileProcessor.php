<?php

namespace LivingWorld\Import\Processor;

use LivingWorld\Entity\Organism;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Graphics\Frame\Frame;

class ImportFileProcessor
{
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
                        //$this->logger->info(sprintf('position %s:%s is empty', $x, $y));
                        $numberOfNeighbours = $previousFrame->getNumberOfSameTypeNeighbours($x, $y);
                        if ($numberOfNeighbours === 3) {
                            // give a BIRTH
                            // @todo: get type of the new organism
                            $survivingOrganisms[] = new Organism($x, $y, OrganismTypeEnum::TYPE_HARKONNEN);
                            //$this->logger->info('creating a new organism');
                        }
                    } else {
                        $numberOfNeighbours = $previousFrame->getNumberOfSameTypeNeighbours($x, $y);
                        //$this->logger->info(sprintf('position %s:%s has got %s neighbours', $x, $y, $numberOfNeighbours));
                        if ($numberOfNeighbours >= 4 || $numberOfNeighbours < 2) {
                            // kill THEM ALL -->> skip cloning
                            //$this->logger->info('dying one');
                        } else {
                            // clone
                            //$this->logger->info('a new clone');
                            $survivingOrganisms[] = clone $previousFrame->getPosition($x, $y);
                        }
                    }
                }
            }
        }

        return $survivingOrganisms;
    }
}
