<?php

declare(strict_types = 1);

namespace LivingWorld\Generate\XmlFile\Dom;

use DOMDocument;
use DOMElement;
use LivingWorld\Enum\XmlFileElementEnum;

class DomElementFactory
{

    public function getXmlElementWithNumericValue(DOMDocument $document, XmlFileElementEnum $element, int $numericValue): DOMElement
    {
        return $this->getXmlElementWithStringValue($document, $element, (string) $numericValue);
    }

    public function getXmlElementWithStringValue(DOMDocument $document, XmlFileElementEnum $element, string $numericValue): DOMElement
    {
        return $document->createElement($element->getValue(), $numericValue);
    }

}
