<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor\LifeCycle;

use LivingWorld\Entity\OrganismList;
use LivingWorld\Graphics\Frame\Frame;

interface LifeCycleProcessorInterface
{

    public function handlesPosition(Frame $frame, int $x, int $y): bool;

    public function getOrganismsForPosition(Frame $frame, int $x, int $y): OrganismList;

}
