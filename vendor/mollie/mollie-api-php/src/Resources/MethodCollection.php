<?php

namespace Mollie\Api\Resources;

class MethodCollection extends BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "methods";
    }
}
