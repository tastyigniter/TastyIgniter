<?php

declare(strict_types=1);

namespace Mollie\Api\Resources;

class BalanceTransactionCollection extends CursorCollection
{
    /**
     * @inheritDoc
     */
    public function getCollectionResourceName()
    {
        return "balance_transactions";
    }

    /**
     * @inheritDoc
     */
    protected function createResourceObject()
    {
        return new BalanceTransaction($this->client);
    }
}
