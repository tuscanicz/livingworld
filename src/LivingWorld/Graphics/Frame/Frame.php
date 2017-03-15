<?php

namespace LivingWorld\Graphics\Frame;

use LivingWorld\Entity\Organism;
use LivingWorld\Graphics\Grid\Grid;

class Frame
{
    private $coordinates;
    private $grid;
    private $organisms;
    private $remainingFrames;
    private $frameNumber;

    /**
     * @param Grid $grid
     * @param Organism[] $organisms
     * @param int $remainingFrames
     * @param int $frameNumber
     */
    public function __construct(Grid $grid, array $organisms, int $remainingFrames, int $frameNumber)
    {
        $rows = $grid->getRows();
        foreach ($organisms as $organism) {
            $rows[$organism->getXPosition()][$organism->getYPosition()] = $organism;
        }
        $this->coordinates = $rows;
        $this->grid = $grid;
        $this->organisms = $organisms;
        $this->remainingFrames = $remainingFrames;
        $this->frameNumber = $frameNumber;
    }

    public function isPositionEmpty(int $xPosition, int $yPosition)
    {
        return $this->coordinates[$xPosition][$yPosition] === null;
    }

    /**
     * @param int $xPosition
     * @param int $yPosition
     * @return Organism
     */
    public function getPosition(int $xPosition, int $yPosition)
    {
        return $this->coordinates[$xPosition][$yPosition];
    }

    public function getNumberOfSameTypeNeighbours(int $xPosition, int $yPosition)
    {
        $deltas = [[0, 1], [0, -1], [1, 0], [-1, 0], [1, 1], [1, -1], [-1, 1], [-1, -1]];
        $count = 0;
        foreach ($deltas as $delta) {
            $xPositionOfNeighbour = $xPosition + $delta[0];
            $yPositionOfNeighbour = $yPosition + $delta[1];
            if (
                $xPositionOfNeighbour < $this->getGrid()->getSize() &&
                $xPositionOfNeighbour >= 0 &&
                $yPositionOfNeighbour < $this->getGrid()->getSize() &&
                $yPositionOfNeighbour >= 0
            ) {
                if ($this->isPositionEmpty($xPositionOfNeighbour, $yPositionOfNeighbour) === false) {
                    // @todo: ressolve neighbours type and aggregate the results
                    $count++;
                }
            }
        }

        return $count;
    }

    public function getGrid()
    {
        return $this->grid;
    }

    public function hasOrganisms()
    {
        return $this->getOrganismsCount() > 0;
    }

    public function getOrganismsCount()
    {
        return count($this->getOrganisms());
    }

    public function getOrganisms()
    {
        return $this->organisms;
    }

    public function getRemainingFrames()
    {
        return $this->remainingFrames;
    }

    public function getFrameNumber()
    {
        return $this->frameNumber;
    }
}
