<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchRetrieveInventoryCountsRequest;

/**
 * Builder for model BatchRetrieveInventoryCountsRequest
 *
 * @see BatchRetrieveInventoryCountsRequest
 */
class BatchRetrieveInventoryCountsRequestBuilder
{
    /**
     * @var BatchRetrieveInventoryCountsRequest
     */
    private $instance;

    private function __construct(BatchRetrieveInventoryCountsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch retrieve inventory counts request Builder object.
     */
    public static function init(): self
    {
        return new self(new BatchRetrieveInventoryCountsRequest());
    }

    /**
     * Sets catalog object ids field.
     */
    public function catalogObjectIds(?array $value): self
    {
        $this->instance->setCatalogObjectIds($value);
        return $this;
    }

    /**
     * Unsets catalog object ids field.
     */
    public function unsetCatalogObjectIds(): self
    {
        $this->instance->unsetCatalogObjectIds();
        return $this;
    }

    /**
     * Sets location ids field.
     */
    public function locationIds(?array $value): self
    {
        $this->instance->setLocationIds($value);
        return $this;
    }

    /**
     * Unsets location ids field.
     */
    public function unsetLocationIds(): self
    {
        $this->instance->unsetLocationIds();
        return $this;
    }

    /**
     * Sets updated after field.
     */
    public function updatedAfter(?string $value): self
    {
        $this->instance->setUpdatedAfter($value);
        return $this;
    }

    /**
     * Unsets updated after field.
     */
    public function unsetUpdatedAfter(): self
    {
        $this->instance->unsetUpdatedAfter();
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Sets states field.
     */
    public function states(?array $value): self
    {
        $this->instance->setStates($value);
        return $this;
    }

    /**
     * Unsets states field.
     */
    public function unsetStates(): self
    {
        $this->instance->unsetStates();
        return $this;
    }

    /**
     * Sets limit field.
     */
    public function limit(?int $value): self
    {
        $this->instance->setLimit($value);
        return $this;
    }

    /**
     * Unsets limit field.
     */
    public function unsetLimit(): self
    {
        $this->instance->unsetLimit();
        return $this;
    }

    /**
     * Initializes a new batch retrieve inventory counts request object.
     */
    public function build(): BatchRetrieveInventoryCountsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
