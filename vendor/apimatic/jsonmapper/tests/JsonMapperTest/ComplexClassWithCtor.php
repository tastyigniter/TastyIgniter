<?php

class ComplexClassWithCtor
{
    private $attribute_1;
    private $attribute_2;

    /**
     * @var int
     */
    public $attr3;

    /**
     * @maps $attr4
     */
    public $foo = false;

    private $attr5;

    public $anotherProp;

    private $anotherSetter;

    public function __construct($attr1, $attr2, $attr3, $attr4, $attr5)
    {
        $this->attribute_1 = $attr1;
        $this->attribute_2 = $attr2;
        $this->attr3 = $attr3 + 1;
        $this->foo = $attr4;
        $attr5[] = 'last';
        $this->attr5 = $attr5;
    }

    /**
     * @param array
     */
    public function setAttr5($val) {
        $this->attr5 = $val;
    }

    public function getAttr5()
    {
        return $this->attr5;
    }

    public function getAttr1()
    {
        return $this->attribute_1;
    }

    public function getAttr2()
    {
        return $this->attribute_2;
    }

    public function getAnotherSetter()
    {
        return $this->anotherSetter;
    }

    public function setAnotherSetter($val)
    {
        $this->anotherSetter = $val . ' new';
    }
}
