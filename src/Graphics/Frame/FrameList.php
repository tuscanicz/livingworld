<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics\Frame;

use Consistence\InvalidArgumentException;
use Consistence\Type\Type;

class FrameList
{

    /**
     * @var Frame[]
     */
    private array $frames;

    /**
     * @param Frame[] $frames
     * @throws InvalidArgumentException
     */
    public function __construct(array $frames)
    {
        Type::checkType($frames, Frame::class.'[]');
        $this->frames = $frames;
    }

    /**
     * @return Frame[]
     */
    public function getFrames(): array
    {
        return $this->frames;
    }

    public function hasFrames(): bool
    {
        return $this->getFramesCount() > 0;
    }

    public function getFramesCount(): int
    {
        return count($this->getFrames());
    }

    public function getLastFrame(): Frame
    {
        if ($this->hasFrames() === true) {
            return $this->frames[$this->getFramesCount() - 1];
        }

        throw new \InvalidArgumentException('Cannot get last frame for empty frame list');
    }

}
