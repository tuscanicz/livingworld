<?php

namespace LivingWorld\Import\XmlFile\Output;

use LivingWorld\Generate\XmlFile\Structure\Organism\Organism;
use LivingWorld\Generate\XmlFile\Structure\WorldStructure;
use LivingWorld\Graphics\Frame\Frame;

class WorldStructureGetter
{
    public function getWordStructureFromFrame(Frame $frame)
    {
        $organisms = [];
        if ($frame->hasOrganisms() === true) {
            foreach ($frame->getOrganisms() as $organism) {
                $organisms[] = new Organism(
                    $organism->getXPosition(),
                    $organism->getYPosition(),
                    $organism->getType()
                );
            }
        }

        return new WorldStructure(
            $frame->getGrid()->getSize(),
            $frame->getOrganismsCount(),
            $frame->getFrameNumber(),
            $organisms
        );
    }
}
