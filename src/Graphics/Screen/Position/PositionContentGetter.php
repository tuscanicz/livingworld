<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics\Screen\Position;

use LivingWorld\Graphics\Format\OrganismSignEnum;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\OrganismTypeFormatter;

class PositionContentGetter
{

    private OrganismTypeFormatter $organismTypeFormatter;

    public function __construct(
        OrganismTypeFormatter $organismTypeFormatter
    ) {
        $this->organismTypeFormatter = $organismTypeFormatter;
    }

    public function getPositionContent(Frame $frame, int $x, int $y): string
    {
        if ($frame->isPositionEmpty($x, $y) === false) {
            $organism = $frame->getPosition($x, $y);

            return $this->organismTypeFormatter->formatOutput(
                new OrganismSignEnum(OrganismSignEnum::ORGANISM_DEFAULT_SIGN),
                $organism->getType()->getValue()
            );
        } else {

            return OrganismSignEnum::ORGANISM_NONE_SIGN;
        }
    }

}
