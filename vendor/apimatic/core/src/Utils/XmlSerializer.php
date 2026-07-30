<?php

declare(strict_types=1);

namespace Core\Utils;

use DOMDocument;

class XmlSerializer
{
    /**
     * @var DOMDocument
     */
    private $dom;

    public function __construct(array $options)
    {
        $this->dom = static::createDomDocumentFromContext($options);
    }

    public function serialize(string $rootName, $value): string
    {
        $this->addAsSubelement($this->dom, $rootName, $value);
        return $this->dom->saveXML();
    }

    public function serializeArray(string $rootName, string $itemName, $value): string
    {
        $this->addArrayAsSubelement($this->dom, $itemName, $value, $rootName);
        return $this->dom->saveXML();
    }

    public function serializeMap(string $rootName, $entries): string
    {
        $this->addMapAsSubelement($this->dom, $rootName, $entries);
        return $this->dom->saveXML();
    }

    public function addAsAttribute(\DOMElement $element, $name, $value): void
    {
        if ($value === null) {
            return;
        }

        $element->setAttribute($name, $this->convertSimple($value));
    }

    public function addMapAsSubelement(\DOMNode $root, string $name, $entries): void
    {
        if ($entries === null) {
            return;
        }

        $parent = $this->createElement($name);
        $root->appendChild($parent);

        foreach ($entries as $key => $value) {
            $element = $this->addAsSubelement($parent, 'entry', $value);

            if ($element !== null) {
                $element->setAttribute('key', $key);
            }
        }
    }

    public function addArrayAsSubelement(
        \DOMNode $root,
        string $itemName,
        $items,
        string $wrappingElementName = null
    ): void {
        if ($items === null) {
            return;
        }

        if ($wrappingElementName === null) {
            $parent = $root;
        } else {
            $parent = $this->createElement($wrappingElementName);
            $root->appendChild($parent);
        }

        foreach ($items as $item) {
            $this->addAsSubelement($parent, $itemName, $item);
        }
    }

    public function addAsSubelement(\DOMNode $root, string $name, $value): ?\DOMElement
    {
        if ($value === null) {
            return null;
        }

        if (\is_object($value) && \method_exists($value, 'toXmlElement')) {
            $element = $this->createElement($name);
            $value->toXmlElement($this, $element);
        } else {
            $element = $this->createElement($name, $this->convertSimple($value));
        }

        $root->appendChild($element);
        return $element;
    }

    public function createElement(string $name, string $value = null): \DOMElement
    {
        return $value === null ? $this->dom->createElement($name) : $this->dom->createElement($name, $value);
    }

    private function convertSimple($value): string
    {
        if (\is_bool($value)) {
            return $value ? 'true' : 'false';
        } else {
            return \strval($value);
        }
    }

    /**
     * Create a DOM document, taking serializer options into account.
     *
     * @param array $context Options that the encoder has access to
     */
    private static function createDomDocumentFromContext(array $context): DOMDocument
    {
        $document = new DOMDocument();

        // Set an attribute on the DOM document specifying, as part of the XML declaration,
        $xmlOptions = [
            // nicely formats output with indentation and extra space
            'formatOutput',
            // the version number of the document
            'xmlVersion',
            // the encoding of the document
            'encoding',
            // whether the document is standalone
            'xmlStandalone',
        ];

        foreach ($xmlOptions as $xmlOption) {
            if (isset($context[$xmlOption])) {
                $document->$xmlOption = $context[$xmlOption];
            }
        }

        return $document;
    }
}
