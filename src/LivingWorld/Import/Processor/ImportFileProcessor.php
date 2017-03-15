<?php

namespace LivingWorld\Import\Processor;


use LivingWorld\Graphics\Frame\Frame;

class ImportFileProcessor
{
    public function process(Frame $frame)
    {
        return new Frame(
            $frame->getGrid(),
            $frame->getOrganisms(),
            $frame->getRemainingFrames() - 1,
            $frame->getFrameNumber() + 1
        );
    }
}
