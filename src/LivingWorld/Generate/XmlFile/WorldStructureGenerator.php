<?php

declare(strict_types = 1);

namespace LivingWorld\Generate\XmlFile;

use Consistence\Type\ArrayType\ArrayType;
use LivingWorld\Generate\XmlFile\Structure\Organism\Organism;
use LivingWorld\Generate\XmlFile\Structure\Organism\OrganismList;
use LivingWorld\Generate\XmlFile\Structure\Organism\RandomOrganismTypeGetter;
use LivingWorld\Generate\XmlFile\Structure\WorldStructure;

class WorldStructureGenerator
{

    private RandomOrganismTypeGetter $randomOrganismTypeGetter;

    public function __construct(RandomOrganismTypeGetter $randomOrganismTypeGetter)
    {
        $this->randomOrganismTypeGetter = $randomOrganismTypeGetter;
    }

    public function generateWorldStructure(int $numberOfCells, int $numberOfSpecies, int $numberOfIterations): WorldStructure
    {
        $organisms = new OrganismList([]);
        $filledCoordinates = [];
        do {
            $newOrganism = $this->generateRandomOrganism($numberOfCells - 1);
            if (ArrayType::containsValue($filledCoordinates, $newOrganism->getPositionId()) === false) {
                $organisms = $organisms->addOrganism($newOrganism);
                $filledCoordinates[] = $newOrganism->getPositionId();
            }
        } while ($organisms->getOrganismsCount() < $numberOfSpecies);

        return new WorldStructure(
            $numberOfCells,
            $numberOfSpecies,
            $numberOfIterations,
            $organisms
        );
    }

    private function generateRandomOrganism(int $maxCellIndex): Organism
    {
        if ($maxCellIndex >= 0) {
            return new Organism(
                random_int(0, $maxCellIndex),
                random_int(0, $maxCellIndex),
                $this->randomOrganismTypeGetter->getRandomOrganismType()
            );
        }

        throw new \InvalidArgumentException('Could not generate ');
    }

}
