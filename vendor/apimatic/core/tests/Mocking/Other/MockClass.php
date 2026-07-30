<?php

namespace Core\Tests\Mocking\Other;

use Core\Utils\XmlDeserializer;
use Core\Utils\XmlSerializer;

class MockClass implements \JsonSerializable
{
    public $body;
    public function __construct(array $body)
    {
        $this->body = $body;
    }

    public $additionalProperties = [];

    /**
     * Add a property to this model.
     *
     * @param string $name Name of property
     * @param mixed $value Value of property
     */
    public function addAdditionalProperty(string $name, $value)
    {
        $this->additionalProperties[$name] = $value;
    }

    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize()
    {
        $json = ['body' => $this->body];
        return array_merge($json, $this->additionalProperties);
    }

    /**
     * Encode this object to XML
     */
    public function toXmlElement(XmlSerializer $serializer, \DOMElement $element): void
    {
        $serializer->addArrayAsSubelement($element, 'body', $this->body);
        $serializer->addArrayAsSubelement($element, 'bodyNull', null);
        $serializer->addAsSubelement($element, 'new1', 'this is new');
        $serializer->addAsSubelement($element, 'new1Null', null);
        $serializer->addMapAsSubelement($element, 'new2', ['key1' => 'val1', 'key2' => 'val2']);
        $serializer->addMapAsSubelement($element, 'new2Null', null);
        $serializer->addAsAttribute($element, 'attr', 'this is attribute');
        $serializer->addAsAttribute($element, 'attrNull', null);
    }

    /**
     * Create a new instance of this class from an XML Element
     */
    public static function fromXmlElement(XmlDeserializer $serializer, \DOMElement $element)
    {
        $body = $serializer->fromElementToArray($element, 'body', 'array');
        $body[] = $serializer->fromElement($element, 'new1', 'string');
        $body[] = $serializer->fromElementToMap($element, 'new2', 'array');
        $body[] = $serializer->fromAttribute($element, 'attr', 'string');
        $body[] = $serializer->fromAttribute($element, 'attrNull', '?string');

        return new self($body);
    }
}
