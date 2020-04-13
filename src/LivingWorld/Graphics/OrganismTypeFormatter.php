<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics;

use Exception;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Graphics\Format\OrganismSignEnum;

class OrganismTypeFormatter
{

    public function formatOutput(OrganismSignEnum $sign, string $format): string
    {
        if (OrganismTypeEnum::hasValue($format) === true) {

            return $this->format($sign->getValue(), $format);
        }

        throw new Exception('Unresolved output format: '.$format);
    }

    private function format(string $string, string $format): string
    {
        return sprintf(
            '<%s>%s</%s>',
            $format,
            $string,
            $format
        );
    }

}
