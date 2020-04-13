<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor\LifeCycle\Exception;

use LivingWorld\Enum\OrganismTypeEnum;

class OrganismWillDieException extends \RuntimeException
{

    private int $numberOfNeighbours;
    private OrganismTypeEnum $organismType;

    public function __construct(int $numberOfNeighbours, OrganismTypeEnum $organismType, ?\Throwable $previous = null)
    {
        $this->numberOfNeighbours = $numberOfNeighbours;
        $this->organismType = $organismType;
        parent::__construct(
            sprintf(
                'Organism will die due to: %s neighbours count',
                $numberOfNeighbours
            ),
            0,
            $previous
        );
    }

    public function getNumberOfNeighbours(): int
    {
        return $this->numberOfNeighbours;
    }

    public function getOrganismType(): OrganismTypeEnum
    {
        return $this->organismType;
    }

}
