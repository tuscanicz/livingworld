<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics\Frame;

use LivingWorld\Entity\Organism;
use LivingWorld\Entity\OrganismList;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Graphics\Grid\Grid;

class Frame
{

    /**
     * @var array<int, array<int, Organism|null>>
     */
    private array $coordinates;
    private Grid $grid;
    private OrganismList $organisms;
    private int $remainingFrames;
    private int $frameNumber;

    public function __construct(Grid $grid, OrganismList $organisms, int $remainingFrames, int $frameNumber)
    {
        $rows = $grid->getGridWithEmptyRows();
        if ($organisms->hasOrganisms() === true) {
            foreach ($organisms->getOrganisms() as $organism) {
                $rows[$organism->getXPosition()][$organism->getYPosition()] = $organism;
            }
        }
        $this->coordinates = $rows;
        $this->grid = $grid;
        $this->organisms = $organisms;
        $this->remainingFrames = $remainingFrames;
        $this->frameNumber = $frameNumber;
    }

    public function isPositionEmpty(int $xPosition, int $yPosition): bool
    {
        return $this->coordinates[$xPosition][$yPosition] === null;
    }

    public function isPositionInGrid(int $xOrYPosition): bool
    {
        return $xOrYPosition < $this->getGrid()->getSize() && $xOrYPosition >= 0;
    }

    public function getPosition(int $xPosition, int $yPosition): Organism
    {
        return $this->coordinates[$xPosition][$yPosition];
    }

    public function isPositionOfType(int $xPosition, int $yPosition, OrganismTypeEnum $organismType): bool
    {
        if ($this->isPositionEmpty($xPosition, $yPosition) === false) {
            if ($organismType->is($this->getPosition($xPosition, $yPosition)->getType()) === true) {
                return true;
            }
        }

        return false;
    }

    public function getNumberOfSameTypeNeighbours(int $xPosition, int $yPosition, OrganismTypeEnum $organismType): int
    {
        $deltas = [[0, 1], [0, -1], [1, 0], [-1, 0], [1, 1], [1, -1], [-1, 1], [-1, -1]];
        $count = 0;
        foreach ($deltas as $delta) {
            $xPositionOfNeighbour = $xPosition + $delta[0];
            $yPositionOfNeighbour = $yPosition + $delta[1];
            if ($this->isPositionInGrid($xPositionOfNeighbour) === true && $this->isPositionInGrid($yPositionOfNeighbour) === true) {
                if ($this->isPositionOfType($xPositionOfNeighbour, $yPositionOfNeighbour, $organismType) === true) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function getGrid(): Grid
    {
        return $this->grid;
    }

    public function getOrganisms(): OrganismList
    {
        return $this->organisms;
    }

    public function getRemainingFrames(): int
    {
        return $this->remainingFrames;
    }

    public function getFrameNumber(): int
    {
        return $this->frameNumber;
    }

}
