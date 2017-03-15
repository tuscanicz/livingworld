<?php

namespace LivingWorld\Import\XmlFile;

use DOMDocument;
use DOMNodeList;
use Exception;
use LivingWorld\Entity\Organism;
use LivingWorld\Enum\OrganismTypeEnum;
use LivingWorld\Enum\XmlFileElementEnum;
use LivingWorld\Graphics\Frame\Frame;
use LivingWorld\Graphics\Grid\Grid;

class XmlFileParser
{
    private $tmpDir;

    public function __construct(string $tmpDir)
    {
        $this->tmpDir = $tmpDir;
    }

    public function parseXmlFile($xmlFilePath)
    {
        $fileName = $this->tmpDir.DIRECTORY_SEPARATOR.$xmlFilePath;
        if (file_exists($fileName) === true) {
            $document = new DOMDocument('1.0', 'utf-8');
            $document->loadXML(file_get_contents($fileName));

            $lifeElements = $document->getElementsByTagName(XmlFileElementEnum::LIFE_ELEMENT);
            $life = $lifeElements->item(0);

            $cellElements = $life->getElementsByTagName(XmlFileElementEnum::WORLD_CELLS_ELEMENT);
            $cellElementsCount = $cellElements->item(0)->nodeValue;
            $iterationElements = $life->getElementsByTagName(XmlFileElementEnum::WORLD_ITERATIONS_ELEMENT);
            $iterationCount = $iterationElements->item(0)->nodeValue;

            $organismsElements = $life->getElementsByTagName(XmlFileElementEnum::ORGANISMS_ELEMENT);
            $organismElements = $organismsElements->item(0)->getElementsByTagName(XmlFileElementEnum::ORGANISM_ELEMENT);

            return new Frame(
                new Grid($cellElementsCount),
                $this->getOrganisms($organismElements),
                $iterationCount,
                1
            );

        } else {

            throw new Exception('Cannot load Xml data: File does not exits: ' . $fileName);
        }
    }

    private function getOrganisms(DOMNodeList $organismElements)
    {
        $organisms = [];
        for ($i = 0; $i < $organismElements->length; $i++) {
            $xPositionElement = $organismElements->item($i)->getElementsByTagName(XmlFileElementEnum::ORGANISM_X_POSITION_ELEMENT);
            $yPositionElement = $organismElements->item($i)->getElementsByTagName(XmlFileElementEnum::ORGANISM_Y_POSITION_ELEMENT);
            $typeElement = $organismElements->item($i)->getElementsByTagName(XmlFileElementEnum::ORGANISM_TYPE_ELEMENT);
            $organisms[] = new Organism(
                (int)$xPositionElement->item(0)->nodeValue,
                (int)$yPositionElement->item(0)->nodeValue,
                new OrganismTypeEnum($typeElement->item(0)->nodeValue)
            );
        }

        return $organisms;
    }
}
