<?php

use apimatic\jsonmapper\JsonMapper;

class JsonMapperForCheckingAllowedPaths extends JsonMapper
{
    function isPathAllowed($filePath, $allowedPaths)
    {
        return parent::isPathAllowed($filePath, $allowedPaths);
    }
}
