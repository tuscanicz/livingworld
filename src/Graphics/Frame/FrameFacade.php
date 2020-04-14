<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics\Frame;

use LivingWorld\Entity\Organism;

class FrameFacade
{

    public function getSurvivalCandidateFromPosition(Frame $frame, int $x, int $y): Organism
    {
        if ($frame->isPositionEmpty($x, $y) === false) {
            return clone $frame->getPosition($x, $y);
        }

        throw new \LogicException(
            sprintf(
                'Trying to clone position %d:%d that is empty',
                $x,
                $y
            )
        );
    }

}
