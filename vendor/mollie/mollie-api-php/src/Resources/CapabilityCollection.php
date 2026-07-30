<?php

namespace Mollie\Api\Resources;

class CapabilityCollection extends BaseCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "capabilities";
    }
}
