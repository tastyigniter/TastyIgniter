<?php

namespace Mollie\Api\Resources;

class PaymentCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "payments";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Payment($this->client);
    }
}
