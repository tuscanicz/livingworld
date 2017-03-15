<?php

namespace LivingWorld\Generate\XmlFile;

use DOMDocument;
use DOMElement;
use LivingWorld\Enum\XmlFileElementEnum;
use LivingWorld\Generate\XmlFile\Structure\Organism\Organism;
use LivingWorld\Generate\XmlFile\Structure\WorldStructure;

class XmlFileGetter
{
    public function getXmlFile(WorldStructure $worldStructure): string
    {
        $document = new DOMDocument('1.0', 'utf-8');

        $world = $document->createElement(XmlFileElementEnum::WORLD_ELEMENT);
        $world->appendChild(
            $document->createElement(XmlFileElementEnum::WORLD_CELLS_ELEMENT, $worldStructure->getNumberOfCells())
        );
        $world->appendChild(
            $document->createElement(XmlFileElementEnum::WORLD_SPECIES_ELEMENT, $worldStructure->getNumberOfSpecies())
        );
        $world->appendChild(
            $document->createElement(XmlFileElementEnum::WORLD_ITERATIONS_ELEMENT, $worldStructure->getNumberOfIterations())
        );
        $organisms = $this->getOrganismsElement($document, $worldStructure->getOrganisms());
        $world->appendChild($organisms);

        $life = $document->createElement(XmlFileElementEnum::LIFE_ELEMENT);
        $life->appendChild($world);
        $document->appendChild($life);

        return $document->saveXML();
    }

    /**
     * @param DOMDocument $document
     * @param Organism[] $organisms
     * @return DOMElement
     */
    private function getOrganismsElement(DOMDocument $document, array $organisms)
    {
        $organismsElement = $document->createElement(XmlFileElementEnum::ORGANISMS_ELEMENT);
        foreach ($organisms as $organism) {
            $organismElement = $document->createElement(XmlFileElementEnum::ORGANISM_ELEMENT);
            $organismElement->appendChild(
                $document->createElement(XmlFileElementEnum::ORGANISM_X_POSITION_ELEMENT, $organism->getXPosition())
            );
            $organismElement->appendChild(
                $document->createElement(XmlFileElementEnum::ORGANISM_Y_POSITION_ELEMENT, $organism->getYPosition())
            );
            $organismElement->appendChild(
                $document->createElement(XmlFileElementEnum::ORGANISM_TYPE_ELEMENT, $organism->getType())
            );
            $organismsElement->appendChild($organismElement);
        }

        return $organismsElement;
    }
}
