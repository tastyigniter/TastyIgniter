<?php

namespace Mollie\Api\Resources;

class PaymentLinkCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "payment_links";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new PaymentLink($this->client);
    }
}
