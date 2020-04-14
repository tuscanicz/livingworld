<?php

declare(strict_types = 1);

namespace LivingWorld\Entity;

use Consistence\InvalidArgumentException;
use Consistence\Type\Type;

class OrganismList
{

    /**
     * @var Organism[]
     */
    private array $organisms;

    /**
     * @param Organism[] $organisms
     * @throws InvalidArgumentException
     */
    public function __construct(array $organisms)
    {
        Type::checkType($organisms, Organism::class.'[]');
        $this->organisms = $organisms;
    }

    /**
     * @return Organism[]
     */
    public function getOrganisms(): array
    {
        return $this->organisms;
    }

    public function hasOrganisms(): bool
    {
        return $this->getOrganismsCount() > 0;
    }

    public function getOrganismsCount(): int
    {
        return count($this->getOrganisms());
    }

    public function getRandomOrganism(): Organism
    {
        if ($this->hasOrganisms() === true) {
            return $this->organisms[array_rand($this->organisms)];
        }

        throw new \InvalidArgumentException('Cannot get random organism from empty list');
    }

}
