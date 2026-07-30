<?php

require_once 'ValueObject.php';

class Php7TypedClass
{
    private $name;
    private $age;
    private $value;

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setAge(int $age)
    {
        $this->age = $age;
    }    

    public function getAge(): int
    {
        return $this->age;
    }

    public function setValue(JsonMapperTest_ValueObject $value)
    {
        $this->value = $value;
    }    

    public function getValue(): JsonMapperTest_ValueObject
    {
        return $this->value;
    }
}
