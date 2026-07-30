<?php

require_once 'ValueObject.php';

class Php7_1TypedClass
{
    private $nullableArray;

    /**
     * @param JsonMapperTest_ValueObject[]|null $val
     */
    public function setNullableArray(?array $val)
    {
        $this->nullableArray = $val;
    }

    public function getNullableArray()
    {
        return $this->nullableArray;
    }
}
