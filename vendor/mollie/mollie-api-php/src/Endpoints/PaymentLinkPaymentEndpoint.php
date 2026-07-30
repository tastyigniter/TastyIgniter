<?php

declare(strict_types=1);

namespace Mollie\Api\Endpoints;

use Mollie\Api\Resources\LazyCollection;
use Mollie\Api\Resources\Payment;
use Mollie\Api\Resources\PaymentCollection;
use Mollie\Api\Resources\PaymentLink;

class PaymentLinkPaymentEndpoint extends CollectionEndpointAbstract
{
    protected $resourcePath = 'payment-links_payments';

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new PaymentCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new Payment($this->client);
    }

    public function pageForId(string $paymentLinkId, ?string $from = null, ?int $limit = null, array $filters = [])
    {
        $this->parentId = $paymentLinkId;

        return $this->rest_list($from, $limit, $filters);
    }

    public function pageFor(PaymentLink $paymentLink, ?string $from = null, ?int $limit = null, array $filters = [])
    {
        return $this->pageForId($paymentLink->id, $from, $limit, $filters);
    }

    /**
     * Create an iterator for iterating over payments associated with the provided Payment Link id, retrieved from Mollie.
     *
     * @param string $paymentLinkId
     * @param string|null $from The first resource ID you want to include in your list.
     * @param int|null $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(
        string $paymentLinkId,
        ?string $from = null,
        ?int $limit = null,
        array $parameters = [],
        bool $iterateBackwards = false
    ): LazyCollection {
        $this->parentId = $paymentLinkId;

        return $this->rest_iterator($from, $limit, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over payments associated with the provided Payment Link object, retrieved from Mollie.
     *
     * @param PaymentLink $paymentLink
     * @param string|null $from The first resource ID you want to include in your list.
     * @param int|null $limit
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(
        PaymentLink $paymentLink,
        ?string $from = null,
        ?int $limit = null,
        array $parameters = [],
        bool $iterateBackwards = false
    ): LazyCollection {
        return $this->iteratorForId(
            $paymentLink->id,
            $from,
            $limit,
            $parameters,
            $iterateBackwards
        );
    }
}
