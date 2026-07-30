<?php

/**
 * @discriminator type
 * @discriminatorType base
 */
class JsonMapperTest_SimpleBase
{
    public $afield;

    public $bfield;

    public $type;

    /**
     * Embedded
     * @var JsonMapperTest_SimpleBase
     */
    public $embedded;

    /**
     * Embedded array
     * @var JsonMapperTest_SimpleBase[]
     */
    public $embeddedArray;
}
