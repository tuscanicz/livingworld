<?php

namespace LivingWorld\Generate\XmlFile;

use Exception;

class XmlFileSaver
{
    private $tmpDir;

    public function __construct(string $tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    public function saveXmlFile($xmlFileName, $xmlFileContents)
    {
        if (mb_strlen($xmlFileContents) > 0) {
            if (file_exists($this->tmpDir) === true) {
                $writtenBytes = file_put_contents(
                    $this->tmpDir.DIRECTORY_SEPARATOR.$xmlFileName,
                    $xmlFileContents
                );
                if ($writtenBytes === false || $writtenBytes === 0) {

                    throw new Exception(
                        'Could not save file with name: '.$xmlFileName
                    );
                }
            } else {

                throw new Exception(
                    'Cannot save file into directory: '.$this->tmpDir
                );
            }
        } else {

            throw new Exception(
                'Cannot save empty file with name: '.$xmlFileName
            );
        }
    }
}
