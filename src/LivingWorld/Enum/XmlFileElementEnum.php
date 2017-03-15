<?php

namespace LivingWorld\Enum;

use Enum\AbstractEnum;

class XmlFileElementEnum extends AbstractEnum
{
    const LIFE_ELEMENT = 'life';
    const WORLD_ELEMENT = 'world';
    const WORLD_CELLS_ELEMENT = 'cells';
    const WORLD_SPECIES_ELEMENT = 'species';
    const WORLD_ITERATIONS_ELEMENT = 'iterations';
    const ORGANISMS_ELEMENT = 'organisms';
    const ORGANISM_ELEMENT = 'organism';
    const ORGANISM_X_POSITION_ELEMENT = 'x_pos';
    const ORGANISM_Y_POSITION_ELEMENT = 'y_pos';
    const ORGANISM_TYPE_ELEMENT = 'species';
}
