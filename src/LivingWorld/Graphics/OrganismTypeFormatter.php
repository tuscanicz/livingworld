<?php

namespace LivingWorld\Graphics;

use Exception;
use LivingWorld\Enum\OrganismTypeEnum;

class OrganismTypeFormatter
{
    const ORGANISM_DEFAULT_SIGN = 'X';

    public function formatOutput(string $string, string $format)
    {
        if (OrganismTypeEnum::hasValue($format) === true) {

            return $this->format($string, $format);

        } else {
             throw new Exception('Unresolved output format: '.$format);
        }
    }

    private function format(string $string, string $format)
    {
        return sprintf(
            '<%s>%s</%s>',
            $format,
            $string,
            $format
        );
    }
}
