<?php

namespace Mollie\Api\Resources;

class OrderCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "orders";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Order($this->client);
    }
}
