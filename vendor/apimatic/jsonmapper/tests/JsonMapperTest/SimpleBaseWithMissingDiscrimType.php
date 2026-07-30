<?php

/**
 * @discriminator type
 */
class JsonMapperTest_SimpleBaseWithMissingDiscrimType
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
