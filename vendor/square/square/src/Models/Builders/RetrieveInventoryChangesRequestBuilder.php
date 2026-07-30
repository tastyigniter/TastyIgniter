<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveInventoryChangesRequest;

/**
 * Builder for model RetrieveInventoryChangesRequest
 *
 * @see RetrieveInventoryChangesRequest
 */
class RetrieveInventoryChangesRequestBuilder
{
    /**
     * @var RetrieveInventoryChangesRequest
     */
    private $instance;

    private function __construct(RetrieveInventoryChangesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve inventory changes request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveInventoryChangesRequest());
    }

    /**
     * Sets location ids field.
     */
    public function locationIds(?string $value): self
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
     * Initializes a new retrieve inventory changes request object.
     */
    public function build(): RetrieveInventoryChangesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
