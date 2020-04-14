<?php

declare(strict_types = 1);

namespace LivingWorld\Entity;

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

    public function isTypeOf(string $organismType): bool
    {
        return $this->getType()->is($organismType);
    }

}
