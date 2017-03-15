<?php

namespace LivingWorld\Logger;

use LivingWorld\Graphics\Frame\Frame;
use Monolog\Logger;

class ImportProcessorLogger
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function logOperation(string $message, int $xPosition, int $yPosition, int $numberOfNeighbours, Frame $frame)
    {
        return $this->logger->info(
            $message,
            [
                'frame' => $frame->getFrameNumber(),
                'position' => sprintf('%s:%s', $xPosition, $yPosition),
                'numberOfNeighbours' => $numberOfNeighbours
            ]
        );
    }
}
