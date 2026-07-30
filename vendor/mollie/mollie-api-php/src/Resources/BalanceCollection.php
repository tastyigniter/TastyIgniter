<?php

namespace Mollie\Api\Resources;

class BalanceCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "balances";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Balance($this->client);
    }
}
