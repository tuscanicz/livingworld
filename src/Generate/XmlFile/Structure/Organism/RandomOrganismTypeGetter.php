<?php

declare(strict_types = 1);

namespace LivingWorld\Generate\XmlFile\Structure\Organism;

use LivingWorld\Enum\OrganismTypeEnum;

class RandomOrganismTypeGetter
{

    public function getRandomOrganismType(): OrganismTypeEnum
    {
        $enumValuesAsArray = array_values(OrganismTypeEnum::getEnums());
        $maxEnumValueIndex = count($enumValuesAsArray) - 1;

        return $enumValuesAsArray[random_int(0, $maxEnumValueIndex)];
    }

}
