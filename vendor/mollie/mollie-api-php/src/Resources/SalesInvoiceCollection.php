<?php

namespace Mollie\Api\Resources;

class SalesInvoiceCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "sales_invoices";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new SalesInvoice($this->client);
    }
}
