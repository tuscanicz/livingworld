<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor\LifeCycle\Resolve;

use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Import\Processor\LifeCycle\LifeCycleProcessorInterface;

class LifeCycleProcessorResolver
{

    private LifeCycleProcessorStorage $lifeCycleProcessorStorage;

    public function __construct(
        LifeCycleProcessorStorage $lifeCycleProcessorStorage
    ) {
        $this->lifeCycleProcessorStorage = $lifeCycleProcessorStorage;
    }

    public function resolveProcessorByPositionStatus(Frame $frame, int $x, int $y): LifeCycleProcessorInterface
    {
        if ($this->lifeCycleProcessorStorage->hasLifeCycleProcessors() === true) {
            foreach ($this->lifeCycleProcessorStorage->getLifeCycleProcessors() as $lifeCycleProcessor) {
                if ($lifeCycleProcessor->handlesPosition($frame, $x, $y) === true) {
                    return $lifeCycleProcessor;
                }
            }

            throw new \InvalidArgumentException(
                sprintf(
                    'Could not resolve any life cycle processor for given position %d:%d',
                    $x,
                    $y
                )
            );
        }

        throw new \InvalidArgumentException('Could not resolve any life cycle processor');
    }

}
