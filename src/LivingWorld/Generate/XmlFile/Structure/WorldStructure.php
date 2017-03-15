<?php

namespace LivingWorld\Generate\XmlFile\Structure;

use LivingWorld\Generate\XmlFile\Structure\Organism\Organism;

class WorldStructure
{
    private $numberOfCells;
    private $numberOfSpecies;
    private $numberOfIterations;
    private $organisms;

    /**
     * @param int $numberOfCells
     * @param int $numberOfSpecies
     * @param int $numberOfIterations
     * @param Organism[] $organisms
     */
    public function __construct(int $numberOfCells, int $numberOfSpecies, int $numberOfIterations, array $organisms)
    {
        $this->numberOfCells = $numberOfCells;
        $this->numberOfSpecies = $numberOfSpecies;
        $this->numberOfIterations = $numberOfIterations;
        $this->organisms = $organisms;
    }

    public function getNumberOfCells()
    {
        return $this->numberOfCells;
    }

    public function getNumberOfSpecies()
    {
        return $this->numberOfSpecies;
    }

    public function getNumberOfIterations()
    {
        return $this->numberOfIterations;
    }

    public function getOrganisms()
    {
        return $this->organisms;
    }
}
