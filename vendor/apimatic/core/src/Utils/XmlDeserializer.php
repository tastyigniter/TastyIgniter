<?php

declare(strict_types=1);

namespace Core\Utils;

use DOMDocument;
use Exception;

class XmlDeserializer
{
    /**
     * @var DOMDocument
     */
    private $dom;

    /**
     * @int
     */
    private $loadOptions;

    /**
     * @param int|null $loadOptions  A bit field of LIBXML_* constants
     */
    public function __construct(int $loadOptions = null)
    {
        $this->dom = new DOMDocument();
        $this->loadOptions = $loadOptions ?? (LIBXML_NONET | LIBXML_NOBLANKS);
    }

    public function deserialize(string $xml, string $rootName, string $clazz)
    {
        $this->dom->loadXML($xml, $this->loadOptions);
        return $this->fromElement($this->dom, $rootName, $clazz);
    }

    public function deserializeToArray(
        string $xml,
        string $rootName,
        string $itemName,
        string $clazz
    ) {
        $this->dom->loadXML($xml, $this->loadOptions);
        return $this->fromElementToArray($this->dom, $itemName, $clazz, $rootName);
    }

    public function deserializeToMap(
        string $xml,
        string $rootName,
        string $clazz
    ) {
        $this->dom->loadXML($xml, $this->loadOptions);
        return $this->fromElementToMap($this->dom, $rootName, $clazz);
    }

    public function fromAttribute(\DOMElement $parent, string $name, string $clazz)
    {
        if (!$parent->hasAttribute($name)) {
            static::assertNullable($parent, '@' . $name, $clazz);
            return null;
        }

        $attributeValue = $parent->getAttribute($name);

        return $this->convertSimple($parent->getAttributeNode($name), $attributeValue, $clazz);
    }

    public function fromElement(\DOMNode $parent, string $name, string $clazz)
    {
        $element = static::getChildNodeByTagName($parent, $name);

        if ($element === null) {
            static::assertNullable($parent, $name . '[1]', $clazz);
            return null;
        }

        return $this->convert($element, $clazz);
    }

    public function fromElementToArray(
        \DOMNode $parent,
        string $itemName,
        string $clazz,
        string $wrappingElementName = null
    ) {
        if ($wrappingElementName === null) {
            $elements = static::getChildNodesByTagName($parent, $itemName);
        } else {
            $wrappingElement = static::getChildNodeByTagName($parent, $wrappingElementName);

            if ($wrappingElement === null) {
                static::assertNullable($parent, $wrappingElementName . '[1]', $clazz);
                return null;
            }

            $elements = static::getChildNodesByTagName($wrappingElement, $itemName);
        }

        return \array_map(
            function ($element) use ($clazz) {
                return $this->convert($element, $clazz);
            },
            $elements
        );
    }

    public function fromElementToMap(
        \DOMNode $parent,
        string $name,
        string $clazz
    ) {
        $wrapper = static::getChildNodeByTagName($parent, $name);

        if ($wrapper === null) {
            static::assertNullable($parent, $name . '[1]', $clazz);
            return null;
        }

        $map = [];
        foreach ($wrapper->childNodes as $element) {
            if ($element->nodeType === XML_ELEMENT_NODE && $element->hasAttribute('key') === true) {
                $map[$element->getAttribute('key')] = $this->convert($element, $clazz);
            }
        }

        return $map;
    }

    private function convert(\DOMElement $node, string $clazz)
    {
        $type = static::withoutNullQualifier($clazz);

        if (\class_exists($type) && \method_exists($type, 'fromXmlElement')) {
            return \call_user_func([$type, 'fromXmlElement'], $this, $node);
        }

        return $this->convertSimple($node, $node->textContent, $clazz);
    }

    private function convertSimple(\DOMNode $node, string $value, string $clazz)
    {
        $type = static::withoutNullQualifier($clazz);

        if ($type === 'float') {
            return \is_numeric($value) ? \floatval($value) : static::throwTypeException($node, $value, $clazz);
        } elseif ($type === 'int') {
            return \is_numeric($value) ? \intval($value) :  static::throwTypeException($node, $value, $clazz);
        } elseif ($type === 'bool') {
            return \strcasecmp($value, 'true') === 0 ?:
                (\strcasecmp($value, 'false') === 0 ? false :  static::throwTypeException($node, $value, $clazz));
        }

        return $value;
    }

    private static function assertNullable(\DOMNode $parentNode, string $nodeSubPath, string $clazz): void
    {
        if ($clazz[0] === '?') {
            return;
        }

        $sourceNodePath = static::makeNodePath($parentNode, $nodeSubPath);

        throw new Exception(
            'Required value not found at XML path "' . $sourceNodePath . '" during deserialization.'
        );
    }

    private static function throwTypeException(\DOMNode $sourceNode, $value, string $clazz): void
    {
        throw new Exception(
            'Expected value of type "' . $clazz . '" but got value "' . $value . '" at XML path "' .
            $sourceNode->getNodePath() . '" during deserialization.'
        );
    }

    private static function withoutNullQualifier(string $type): string
    {
        if (\strlen($type) > 1 && $type[0] === '?') {
            return \substr($type, 1);
        }

        return $type;
    }

    private static function makeNodePath(\DOMNode $node, $subpath)
    {
        $parentPath = $node->getNodePath();
        if ($parentPath === '/') {
            $parentPath = '';
        }

        return $parentPath . '/' . $subpath;
    }

    private static function getChildNodeByTagName(\DOMNode $node, string $name): ?\DOMElement
    {
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $childNode) {
                if ($childNode->nodeType === XML_ELEMENT_NODE && $childNode->tagName === $name) {
                    return $childNode;
                }
            }
        }

        return null;
    }

    private static function getChildNodesByTagName(\DOMNode $node, string $name): array
    {
        $arr = [];
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $childNode) {
                if ($childNode->nodeType === XML_ELEMENT_NODE && $childNode->tagName === $name) {
                    $arr[] = $childNode;
                }
            }
        }

        return $arr;
    }
}
