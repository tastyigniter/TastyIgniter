<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchRetrieveOrdersRequest;

/**
 * Builder for model BatchRetrieveOrdersRequest
 *
 * @see BatchRetrieveOrdersRequest
 */
class BatchRetrieveOrdersRequestBuilder
{
    /**
     * @var BatchRetrieveOrdersRequest
     */
    private $instance;

    private function __construct(BatchRetrieveOrdersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch retrieve orders request Builder object.
     */
    public static function init(array $orderIds): self
    {
        return new self(new BatchRetrieveOrdersRequest($orderIds));
    }

    /**
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Initializes a new batch retrieve orders request object.
     */
    public function build(): BatchRetrieveOrdersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
