<?php

declare(strict_types = 1);

namespace LivingWorld\Generate\XmlFile\Structure;

use LivingWorld\Generate\XmlFile\Structure\Organism\OrganismList;

class WorldStructure
{

    private int $numberOfCells;
    private int $numberOfSpecies;
    private int $numberOfIterations;
    private OrganismList $organisms;

    public function __construct(int $numberOfCells, int $numberOfSpecies, int $numberOfIterations, OrganismList $organisms)
    {
        $this->numberOfCells = $numberOfCells;
        $this->numberOfSpecies = $numberOfSpecies;
        $this->numberOfIterations = $numberOfIterations;
        $this->organisms = $organisms;
    }

    public function getNumberOfCells(): int
    {
        return $this->numberOfCells;
    }

    public function getNumberOfSpecies(): int
    {
        return $this->numberOfSpecies;
    }

    public function getNumberOfIterations(): int
    {
        return $this->numberOfIterations;
    }

    public function getOrganisms(): OrganismList
    {
        return $this->organisms;
    }

}
