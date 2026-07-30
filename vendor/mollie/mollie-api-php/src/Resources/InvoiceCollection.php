<?php

namespace Mollie\Api\Resources;

class InvoiceCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "invoices";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Invoice($this->client);
    }
}
