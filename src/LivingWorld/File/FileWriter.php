<?php

declare(strict_types = 1);

namespace LivingWorld\File;

use LivingWorld\File\Exception\UnableToWriteFileException;

class FileWriter
{

    private string $tmpDir;

    public function __construct(string $tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    public function writeFile(string $fileName, string $fileContents): void
    {
        if (mb_strlen($fileContents) > 0) {
            if (file_exists($this->tmpDir) === true) {
                $writtenBytes = file_put_contents(
                    $this->tmpDir.DIRECTORY_SEPARATOR.$fileName,
                    $fileContents
                );
                if ($writtenBytes === false || $writtenBytes === 0) {
                    throw new UnableToWriteFileException(
                        'Could not write file with name: '.$fileName
                    );
                }

                 return;
            }

            throw new UnableToWriteFileException(
                'Cannot write file into directory: '.$this->tmpDir
            );
        }

        throw new UnableToWriteFileException(
            'Cannot write empty file with name: '.$fileName
        );
    }

}
