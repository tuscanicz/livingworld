<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor\LifeCycle\Resolve;

use LivingWorld\Import\Processor\LifeCycle\LifeCycleProcessorInterface;

class LifeCycleProcessorStorage
{

    /** @var LifeCycleProcessorInterface[] */
    private array $lifeCycleProcessors;

    /**
     * @param LifeCycleProcessorInterface[] $lifeCycleProcessors
     */
    public function __construct(array $lifeCycleProcessors = [])
    {
        $this->lifeCycleProcessors = $lifeCycleProcessors;
    }

    public function addLifeCycleProcessor(LifeCycleProcessorInterface $lifeCycleProcessor): void
    {
        $this->lifeCycleProcessors[] = $lifeCycleProcessor;
    }

    /**
     * @return LifeCycleProcessorInterface[]
     */
    public function getLifeCycleProcessors(): array
    {
        return $this->lifeCycleProcessors;
    }

    public function getLifeCycleProcessorsCount(): int
    {
        return count($this->getLifeCycleProcessors());
    }

    public function hasLifeCycleProcessors(): bool
    {
        return $this->getLifeCycleProcessorsCount() > 0;
    }

}
