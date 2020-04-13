<?php

declare(strict_types = 1);

namespace LivingWorld\Command\Result;

use Enum\AbstractEnum;

class CommandResultEnum extends AbstractEnum
{

    public const RESULT_GENERAL_ERROR = 1;
    public const RESULT_SUCCESS = 0;

}
