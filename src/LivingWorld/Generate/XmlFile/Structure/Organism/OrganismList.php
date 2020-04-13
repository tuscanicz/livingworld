<?php

declare(strict_types = 1);

namespace LivingWorld\Generate\XmlFile\Structure\Organism;

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

    public function addOrganism(Organism $organism): self
    {
        $organisms = $this->getOrganisms();
        $organisms[] = $organism;

        return new self($organisms);
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

}
