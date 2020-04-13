<?php

declare(strict_types = 1);

namespace LivingWorld\Logger;

use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Graphics\Frame\Frame;
use Monolog\Logger;

class ImportProcessorLogger
{

    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function logBirthOperation(
        string $message,
        int $xPosition,
        int $yPosition,
        Frame $frame,
        OrganismTypeEnum $organismType
    ): bool {
        return $this->logger->info(
            $message,
            [
                'frame' => $frame->getFrameNumber(),
                'position' => sprintf('%d:%d', $xPosition, $yPosition),
                'type' => $organismType->getValue(),
            ]
        );
    }

    public function logDieOperation(
        string $message,
        int $xPosition,
        int $yPosition,
        int $numberOfNeighbours,
        Frame $frame,
        OrganismTypeEnum $organismType
    ): bool {
        return $this->logger->info(
            $message,
            [
                'frame' => $frame->getFrameNumber(),
                'position' => sprintf('%d:%d', $xPosition, $yPosition),
                'numberOfNeighbours' => $numberOfNeighbours,
                'type' => $organismType->getValue(),
            ]
        );
    }

}
