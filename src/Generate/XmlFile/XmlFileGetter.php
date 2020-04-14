<?php

declare(strict_types = 1);

namespace LivingWorld\Generate\XmlFile;

use DOMDocument;
use DOMElement;
use LivingWorld\Enum\XmlFileElementEnum;
use LivingWorld\Generate\XmlFile\Dom\DomElementFactory;
use LivingWorld\Generate\XmlFile\Structure\Organism\OrganismList;
use LivingWorld\Generate\XmlFile\Structure\WorldStructure;

class XmlFileGetter
{

    private DomElementFactory $domElementFactory;

    public function __construct(DomElementFactory $domElementFactory)
    {
        $this->domElementFactory = $domElementFactory;
    }

    public function getXmlFile(WorldStructure $worldStructure): string
    {
        $document = new DOMDocument('1.0', 'utf-8');

        $world = $document->createElement(XmlFileElementEnum::WORLD_ELEMENT);
        $world->appendChild(
            $this->domElementFactory->getXmlElementWithNumericValue(
                $document,
                new XmlFileElementEnum(XmlFileElementEnum::WORLD_CELLS_ELEMENT),
                $worldStructure->getNumberOfCells()
            )
        );
        $world->appendChild(
            $this->domElementFactory->getXmlElementWithNumericValue(
                $document,
                new XmlFileElementEnum(XmlFileElementEnum::WORLD_SPECIES_ELEMENT),
                $worldStructure->getNumberOfSpecies()
            )
        );
        $world->appendChild(
            $this->domElementFactory->getXmlElementWithNumericValue(
                $document,
                new XmlFileElementEnum(XmlFileElementEnum::WORLD_ITERATIONS_ELEMENT),
                $worldStructure->getNumberOfIterations()
            )
        );
        $world->appendChild(
            $this->getOrganismsElement($document, $worldStructure->getOrganisms())
        );

        $life = $document->createElement(XmlFileElementEnum::LIFE_ELEMENT);
        $life->appendChild($world);
        $document->appendChild($life);

        $documentXmlContents = $document->saveXML();
        if ($documentXmlContents === false) {
            throw new \InvalidArgumentException('Could not get XML file from world structure');
        }

        return $documentXmlContents;
    }

    private function getOrganismsElement(DOMDocument $document, OrganismList $organisms): DOMElement
    {
        $organismsElement = $document->createElement(XmlFileElementEnum::ORGANISMS_ELEMENT);
        if ($organisms->hasOrganisms() === true) {
            foreach ($organisms->getOrganisms() as $organism) {
                $organismElement = $document->createElement(XmlFileElementEnum::ORGANISM_ELEMENT);
                $organismElement->appendChild(
                    $this->domElementFactory->getXmlElementWithNumericValue(
                        $document,
                        new XmlFileElementEnum(XmlFileElementEnum::ORGANISM_X_POSITION_ELEMENT),
                        $organism->getXPosition()
                    )
                );
                $organismElement->appendChild(
                    $this->domElementFactory->getXmlElementWithNumericValue(
                        $document,
                        new XmlFileElementEnum(XmlFileElementEnum::ORGANISM_Y_POSITION_ELEMENT),
                        $organism->getYPosition()
                    )
                );
                $organismElement->appendChild(
                    $this->domElementFactory->getXmlElementWithStringValue(
                        $document,
                        new XmlFileElementEnum(XmlFileElementEnum::ORGANISM_TYPE_ELEMENT),
                        $organism->getType()->getValue()
                    )
                );
                $organismsElement->appendChild($organismElement);
            }
        }

        return $organismsElement;
    }

}
