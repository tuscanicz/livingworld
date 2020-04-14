<?php

declare(strict_types = 1);

namespace LivingWorld\Enum;

use Enum\AbstractEnum;

class XmlFileElementEnum extends AbstractEnum
{

    public const LIFE_ELEMENT = 'life';
    public const WORLD_ELEMENT = 'world';
    public const WORLD_CELLS_ELEMENT = 'cells';
    public const WORLD_SPECIES_ELEMENT = 'species';
    public const WORLD_ITERATIONS_ELEMENT = 'iterations';
    public const ORGANISMS_ELEMENT = 'organisms';
    public const ORGANISM_ELEMENT = 'organism';
    public const ORGANISM_X_POSITION_ELEMENT = 'x_pos';
    public const ORGANISM_Y_POSITION_ELEMENT = 'y_pos';
    public const ORGANISM_TYPE_ELEMENT = 'species';

}
