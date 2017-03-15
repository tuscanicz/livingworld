<?php

namespace LivingWorld\Generate\XmlFile\Structure\Organism;

use LivingWorld\Enum\OrganismTypeEnum;

class RandomOrganismTypeGetter
{
    public function getRandomOrganism()
    {
        $enumValuesAsArray = array_values(OrganismTypeEnum::getValues());
        $maxEnumValueIndex = count($enumValuesAsArray) - 1;

        return $enumValuesAsArray[random_int(0, $maxEnumValueIndex)];
    }
}
