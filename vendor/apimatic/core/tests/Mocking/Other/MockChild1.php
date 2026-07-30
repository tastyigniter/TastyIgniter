<?php

namespace Core\Tests\Mocking\Other;

class MockChild1 extends MockClass implements \JsonSerializable
{
    /**
     * @var string
     */
    public $childBody;

    public function __construct($childBody, array $body)
    {
        $this->childBody = $childBody;
        parent::__construct($body);
    }

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
        $json = ['body' => $this->body, 'childBody' => $this->childBody];
        return array_merge($json, parent::jsonSerialize(), $this->additionalProperties);
    }
}
