<?php

declare(strict_types = 1);

namespace LivingWorld\Graphics\Screen;

use Enum\AbstractEnum;

class FramePerSecondsEnum extends AbstractEnum
{

    public const SLOW_SUPER_MOTION_FPS = 1;
    public const SLOW_MOTION_FPS = 2;
    public const DEFAULT_FPS = 4;
    public const REALISTIC_FPS = 24;

}
