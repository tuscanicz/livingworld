<?php

declare(strict_types = 1);

namespace LivingWorld\Generate\XmlFile\Structure\Organism;

use LivingWorld\Enum\OrganismTypeEnum;

class Organism
{

    private int $xPosition;
    private int $yPosition;
    private OrganismTypeEnum $type;

    public function __construct(int $xPosition, int $yPosition, OrganismTypeEnum $type)
    {
        $this->xPosition = $xPosition;
        $this->yPosition = $yPosition;
        $this->type = $type;
    }

    public function getPositionId(): string
    {
        return $this->getXPosition().':'.$this->getYPosition();
    }

    public function getXPosition(): int
    {
        return $this->xPosition;
    }

    public function getYPosition(): int
    {
        return $this->yPosition;
    }

    public function getType(): OrganismTypeEnum
    {
        return $this->type;
    }

}
