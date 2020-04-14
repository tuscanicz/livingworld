<?php

declare(strict_types = 1);

namespace LivingWorld\Import\XmlFile;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use Exception;
use LivingWorld\Entity\Organism;
use LivingWorld\Entity\OrganismList;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Enum\XmlFileElementEnum;
use LivingWorld\File\FileContentGetter;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\Grid\Grid;

class XmlFileParser
{

    private string $tmpDir;
    private FileContentGetter $fileContentGetter;

    public function __construct(string $tmpDir, FileContentGetter $fileContentGetter)
    {
        $this->tmpDir = $tmpDir;
        $this->fileContentGetter = $fileContentGetter;
    }

    public function parseXmlFile(string $xmlFilePath): Frame
    {
        $fileName = $this->tmpDir.DIRECTORY_SEPARATOR.$xmlFilePath;
        if ($this->fileContentGetter->isFileContentReadable($fileName) === true) {
            $document = new DOMDocument('1.0', 'utf-8');
            $document->loadXML(
                $this->fileContentGetter->getContent($fileName)
            );

            $lifeElements = $document->getElementsByTagName(XmlFileElementEnum::LIFE_ELEMENT);
            /** @var DOMElement $life */
            $life = $lifeElements->item(0);

            $cellElements = $life->getElementsByTagName(XmlFileElementEnum::WORLD_CELLS_ELEMENT);
            $cellElementsCount = (int) $cellElements->item(0)->nodeValue;
            $iterationElements = $life->getElementsByTagName(XmlFileElementEnum::WORLD_ITERATIONS_ELEMENT);
            $iterationCount = (int) $iterationElements->item(0)->nodeValue;

            /** @var DOMElement $organismsElement */
            $organismsElement = $life->getElementsByTagName(XmlFileElementEnum::ORGANISMS_ELEMENT)->item(0);
            $organismElements = $organismsElement->getElementsByTagName(XmlFileElementEnum::ORGANISM_ELEMENT);

            return new Frame(
                new Grid($cellElementsCount),
                $this->getOrganisms($organismElements),
                $iterationCount,
                1
            );

        }

        throw new Exception('Cannot load Xml data: File does not exits: '.$fileName);
    }

    /**
     * @param DOMNodeList<DOMElement> $organismElements
     * @return OrganismList
     */
    private function getOrganisms(DOMNodeList $organismElements): OrganismList
    {
        $organisms = [];
        for ($i = 0; $i < $organismElements->length; $i++) {
            /** @var DOMElement $currenntOrganismElement */
            $currenntOrganismElement = $organismElements->item($i);
            $xPositionElement = $currenntOrganismElement->getElementsByTagName(XmlFileElementEnum::ORGANISM_X_POSITION_ELEMENT);
            $yPositionElement = $currenntOrganismElement->getElementsByTagName(XmlFileElementEnum::ORGANISM_Y_POSITION_ELEMENT);
            $typeElement = $currenntOrganismElement->getElementsByTagName(XmlFileElementEnum::ORGANISM_TYPE_ELEMENT);

            $organisms[] = new Organism(
                (int)$xPositionElement->item(0)->nodeValue,
                (int)$yPositionElement->item(0)->nodeValue,
                new OrganismTypeEnum($typeElement->item(0)->nodeValue)
            );
        }

        return new OrganismList($organisms);
    }

}
