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

    public function isPositionEmpty($xPosition, $yPosition)
    {
        return $this->coordinates[$xPosition][$yPosition] === null;
    }

    /**
     * @param $xPosition
     * @param $yPosition
     * @return Organism
     */
    public function getPosition($xPosition, $yPosition)
    {
        return $this->coordinates[$xPosition][$yPosition];
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
