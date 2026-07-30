<?php

namespace multitypetest;

use apimatic\jsonmapper\JsonMapper;

class MultiTypeJsonMapper extends JsonMapper
{
    public function getType(&$value, $factoryMethods = [], $start = '', $end = '')
    {
        return parent::getType($value, $factoryMethods, $start, $end);
    }

    public function checkForType($typeGroup, $type, $start = '', $end = '')
    {
        return parent::checkForType($typeGroup, $type, $start, $end);
    }

}