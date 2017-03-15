<?php

namespace LivingWorld\Graphics\Screen;

use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\OrganismTypeFormatter;
use Symfony\Component\Console\Output\OutputInterface;

class ScreenWriter
{
    const SLOW_MOTION_FPS = 2;
    const DEFAULT_FPS = 4;
    const REALISTIC_FPS = 24;

    private $organismTypeFormatter;

    public function __construct(
        OrganismTypeFormatter $organismTypeFormatter
    ) {
        $this->organismTypeFormatter = $organismTypeFormatter;
    }

    /**
     * @param Frame[] $frames
     * @param OutputInterface $output
     * @param int $fps
     */
    public function writeScreen(array $frames, OutputInterface $output, int $fps = self::DEFAULT_FPS)
    {
        foreach ($frames as $frame) {
            system('clear');
            $this->writeFrameNumber($frame, $output);
            $this->writeFrameContents($frame, $output);
            usleep(1000000 / $fps);
        }
    }

    private function writeFrameContents(Frame $frame, OutputInterface $output)
    {
        for ($x = 0; $x < $frame->getGrid()->getSize(); $x++) {
            for ($y = 0; $y < $frame->getGrid()->getSize(); $y++) {
                $output->write($this->getPositionContent($frame, $x, $y));
            }
            $output->writeln('');
        }
    }


    private function writeFrameNumber(Frame $frame, OutputInterface $output)
    {
        $output->writeln('#'.(string)$frame->getFrameNumber());
    }

    private function getPositionContent(Frame $frame, int $x, int $y): string
    {
        if ($frame->isPositionEmpty($x, $y) === false) {
            $organism = $frame->getPosition($x, $y);

            return $this->organismTypeFormatter->formatOutput(
                OrganismTypeFormatter::ORGANISM_DEFAULT_SIGN,
                $organism->getType()
            );

        } else {

            return ' ';
        }
    }
}
