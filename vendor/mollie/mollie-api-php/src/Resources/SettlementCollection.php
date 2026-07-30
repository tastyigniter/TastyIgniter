<?php

namespace Mollie\Api\Resources;

class SettlementCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "settlements";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Settlement($this->client);
    }
}
