<?php

declare(strict_types = 1);

namespace LivingWorld\File\Exception;

class UnableToGetContentException extends \RuntimeException
{

    public function __construct(string $path, string $errorMessage, ?\Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                'Path: %s, ErrorMessage: %s',
                $path,
                $errorMessage
            ),
            0,
            $previous
        );
    }

}
