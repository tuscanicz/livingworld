<?php

namespace LivingWorld\Generate\XmlFile;

use LivingWorld\Generate\XmlFile\Structure\Organism\Organism;
use LivingWorld\Generate\XmlFile\Structure\Organism\RandomOrganismTypeGetter;
use LivingWorld\Generate\XmlFile\Structure\WorldStructure;

class WorldStructureGenerator
{
    private $randomOrganismTypeGetter;

    public function __construct(RandomOrganismTypeGetter $randomOrganismTypeGetter)
    {
        $this->randomOrganismTypeGetter = $randomOrganismTypeGetter;
    }

    public function generateWorldStructure(int $numberOfCells, int $numberOfSpecies, int $numberOfIterations)
    {
        $organisms = [];
        $filledCoordinates = [];
        do {
            $newOrganism = $this->generateRandomOrganism($numberOfCells - 1);
            if (in_array($newOrganism->getPositionId(), $filledCoordinates, true) === false) {
                $organisms[] = $newOrganism;
                $filledCoordinates[] = $newOrganism->getPositionId();
            }
        } while (count($organisms) < $numberOfSpecies);

        return new WorldStructure(
            $numberOfCells,
            $numberOfSpecies,
            $numberOfIterations,
            $organisms
        );
    }

    private function generateRandomOrganism($maxCellIndex)
    {
        return new Organism(
            random_int(0, $maxCellIndex),
            random_int(0, $maxCellIndex),
            $this->randomOrganismTypeGetter->getRandomOrganism()
        );
    }
}
