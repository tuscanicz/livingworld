<?php

declare(strict_types = 1);

namespace LivingWorld\Import\Processor\LifeCycle;

use LivingWorld\Entity\Organism;
use LivingWorld\Entity\OrganismList;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Graphics\Frame\Frame;

class BirthProcessor implements LifeCycleProcessorInterface
{

    public function handlesPosition(Frame $frame, int $x, int $y): bool
    {
        return $frame->isPositionEmpty($x, $y) === true;
    }

    public function getOrganismsForPosition(Frame $frame, int $x, int $y): OrganismList
    {
        $organismTypes = OrganismTypeEnum::getEnums();
        $survivalCandidates = [];
        if (count($organismTypes) > 0) {
            foreach ($organismTypes as $organismType) {
                $numberOfNeighbours = $frame->getNumberOfSameTypeNeighbours($x, $y, $organismType);
                if ($numberOfNeighbours === 3) {
                    $survivalCandidates[] = new Organism($x, $y, $organismType);
                }
            }

            return new OrganismList($survivalCandidates);
        }

        throw new \Exception('Cannot process birth: no organism types defined');
    }

}
