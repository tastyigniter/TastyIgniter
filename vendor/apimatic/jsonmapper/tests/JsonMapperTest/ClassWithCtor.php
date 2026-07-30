<?php

class ClassWithCtor
{
    private $attribute_1;
    private $attribute_2;

    public function __construct($attr1, JsonMapperTest_ValueObject $attr2)
    {
        $this->attribute_1 = $attr1;
        $this->attribute_2 = $attr2;
    }

    public function getAttr1()
    {
        return $this->attribute_1;
    }

    public function getAttr2()
    {
        return $this->attribute_2;
    }
}
