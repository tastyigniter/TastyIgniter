<?php

namespace Mollie\Api\Resources;

class RefundCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "refunds";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Refund($this->client);
    }
}
