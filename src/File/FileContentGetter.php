<?php

declare(strict_types = 1);

namespace LivingWorld\File;

use Consistence\Type\ArrayType\ArrayType;
use LivingWorld\File\Exception\UnableToGetContentException;

class FileContentGetter
{

    public function isFileContentReadable(string $path): bool
    {
        return file_exists($path) === true;
    }

    public function getContent(string $path): string
    {
        // @codingStandardsIgnoreLine
        $content = @file_get_contents($path);
        if ($content === false) {
            $error = error_get_last();

            $errorMessage = 'Unresolved error';
            if (is_array($error) === true
                && ArrayType::containsKey($error, 'message') === true
                && $error['message'] !== null
            ) {
                $errorMessage = $error['message'];
            }

            throw new UnableToGetContentException($path, $errorMessage);
        }

        return $content;
    }

}
