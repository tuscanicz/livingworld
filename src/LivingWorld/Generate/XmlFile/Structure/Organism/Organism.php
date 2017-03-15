<?php

namespace LivingWorld\Generate\XmlFile\Structure\Organism;

class Organism
{
    private $xPosition;
    private $yPosition;
    private $type;

    public function __construct(int $xPosition, int $yPosition, string $type)
    {
        $this->xPosition = $xPosition;
        $this->yPosition = $yPosition;
        $this->type = $type;
    }

    public function getPositionId()
    {
        return $this->getXPosition().':'.$this->getYPosition();
    }

    public function getXPosition()
    {
        return $this->xPosition;
    }

    public function getYPosition()
    {
        return $this->yPosition;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isTypeOf(string $organismType)
    {
        return $this->getType() === $organismType;
    }
}
