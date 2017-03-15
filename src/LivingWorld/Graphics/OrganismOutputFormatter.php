<?php

namespace LivingWorld\Graphics;

use LivingWorld\Enum\OrganismTypeEnum;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;

class OrganismOutputFormatter
{
    public function formatOutput(OutputInterface $output)
    {
        $output->getFormatter()->setStyle(OrganismTypeEnum::TYPE_HARKONNEN, new OutputFormatterStyle('red'));
        $output->getFormatter()->setStyle(OrganismTypeEnum::TYPE_ORDOS, new OutputFormatterStyle('green'));
        $output->getFormatter()->setStyle(OrganismTypeEnum::TYPE_ATREIDES, new OutputFormatterStyle('blue'));
    }
}
