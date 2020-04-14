<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor\LifeCycle;

use LivingWorld\Entity\OrganismList;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\Frame\FrameFacade;
use LivingWorld\Import\Processor\LifeCycle\Exception\OrganismWillDieException;

class DieOrSurviveProcessor implements LifeCycleProcessorInterface
{

    private FrameFacade $frameFacade;

    public function __construct(FrameFacade $frameFacade)
    {
        $this->frameFacade = $frameFacade;
    }

    public function handlesPosition(Frame $frame, int $x, int $y): bool
    {
        return $frame->isPositionEmpty($x, $y) === false;
    }

    public function getOrganismsForPosition(Frame $frame, int $x, int $y): OrganismList
    {
        $survivalCandidates = [];
        if ($frame->isPositionEmpty($x, $y) === false) {
            $organismType = $frame->getPosition($x, $y)->getType();
            $numberOfNeighbours = $frame->getNumberOfSameTypeNeighbours($x, $y, $organismType);
            if ($numberOfNeighbours >= 4 || $numberOfNeighbours < 2) {
                throw new OrganismWillDieException($numberOfNeighbours, $organismType);
            } else {
                $survivalCandidates[] = $this->frameFacade->getSurvivalCandidateFromPosition($frame, $x, $y);
            }

            return new OrganismList($survivalCandidates);
        }

        throw new \Exception('Cannot process death or survival: empty position given');
    }

}
