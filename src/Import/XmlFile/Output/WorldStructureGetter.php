<?php

declare(strict_types = 1);

namespace LivingWorld\Import\XmlFile\Output;

use LivingWorld\Generate\XmlFile\Structure\Organism\Organism;
use LivingWorld\Generate\XmlFile\Structure\Organism\OrganismList;
use LivingWorld\Generate\XmlFile\Structure\WorldStructure;
use LivingWorld\Graphics\Frame\Frame;

class WorldStructureGetter
{

    public function getWordStructureFromFrame(Frame $frame): WorldStructure
    {
        $organisms = [];
        if ($frame->getOrganisms()->hasOrganisms() === true) {
            foreach ($frame->getOrganisms()->getOrganisms() as $organism) {
                $organisms[] = new Organism(
                    $organism->getXPosition(),
                    $organism->getYPosition(),
                    $organism->getType()
                );
            }
        }

        return new WorldStructure(
            $frame->getGrid()->getSize(),
            $frame->getOrganisms()->getOrganismsCount(),
            $frame->getFrameNumber(),
            new OrganismList($organisms)
        );
    }

}
