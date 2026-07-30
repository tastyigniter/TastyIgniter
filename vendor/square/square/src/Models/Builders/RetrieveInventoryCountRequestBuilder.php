<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveInventoryCountRequest;

/**
 * Builder for model RetrieveInventoryCountRequest
 *
 * @see RetrieveInventoryCountRequest
 */
class RetrieveInventoryCountRequestBuilder
{
    /**
     * @var RetrieveInventoryCountRequest
     */
    private $instance;

    private function __construct(RetrieveInventoryCountRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve inventory count request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveInventoryCountRequest());
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
     * Initializes a new retrieve inventory count request object.
     */
    public function build(): RetrieveInventoryCountRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
