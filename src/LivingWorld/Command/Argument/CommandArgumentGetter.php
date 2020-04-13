<?php

declare(strict_types = 1);

namespace LivingWorld\Command\Argument;

use Symfony\Component\Console\Input\InputInterface;

class CommandArgumentGetter
{

    public function getIntegerArgument(InputInterface $input, string $argumentName): int
    {
        $rawInput = $input->getArgument($argumentName);
        if (is_array($rawInput) === true) {
            throw new \InvalidArgumentException('Cannot convert array argument into integer '.$argumentName);
        }

        return (int) $rawInput;
    }

    public function getStringArgument(InputInterface $input, string $argumentName): string
    {
        $rawInput = $input->getArgument($argumentName);
        if (is_array($rawInput) === true) {
            throw new \InvalidArgumentException('Cannot convert array argument into string '.$argumentName);
        }

        return (string) $rawInput;
    }

}
