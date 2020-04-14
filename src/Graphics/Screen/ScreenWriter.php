<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics\Screen;

use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\Frame\FrameList;
use LivingWorld\Graphics\Screen\Position\PositionContentGetter;
use Symfony\Component\Console\Output\OutputInterface;

class ScreenWriter
{

    private PositionContentGetter $positionContentGetter;

    public function __construct(
        PositionContentGetter $positionContentGetter
    ) {
        $this->positionContentGetter = $positionContentGetter;
    }

    public function writeScreen(FrameList $frameList, OutputInterface $output, FramePerSecondsEnum $fps): void
    {
        if ($frameList->hasFrames() === true) {
            foreach ($frameList->getFrames() as $frame) {
                system('clear');
                $this->writeFrameNumber($frame, $output);
                $this->writeFrameContents($frame, $output);
                usleep(1000000 / $fps->getValue());
            }

            return;
        }

        throw new \InvalidArgumentException('Could not write screen: no frames given');
    }

    private function writeFrameContents(Frame $frame, OutputInterface $output): void
    {
        for ($x = 0; $x < $frame->getGrid()->getSize(); $x++) {
            for ($y = 0; $y < $frame->getGrid()->getSize(); $y++) {
                $output->write(
                    $this->positionContentGetter->getPositionContent($frame, $x, $y)
                );
            }
            $output->writeln('');
        }
    }

    private function writeFrameNumber(Frame $frame, OutputInterface $output): void
    {
        $output->writeln('#'.(string)$frame->getFrameNumber());
    }

}
