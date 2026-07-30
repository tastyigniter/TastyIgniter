<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BatchChangeInventoryRequest;

/**
 * Builder for model BatchChangeInventoryRequest
 *
 * @see BatchChangeInventoryRequest
 */
class BatchChangeInventoryRequestBuilder
{
    /**
     * @var BatchChangeInventoryRequest
     */
    private $instance;

    private function __construct(BatchChangeInventoryRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new batch change inventory request Builder object.
     */
    public static function init(string $idempotencyKey): self
    {
        return new self(new BatchChangeInventoryRequest($idempotencyKey));
    }

    /**
     * Sets changes field.
     */
    public function changes(?array $value): self
    {
        $this->instance->setChanges($value);
        return $this;
    }

    /**
     * Unsets changes field.
     */
    public function unsetChanges(): self
    {
        $this->instance->unsetChanges();
        return $this;
    }

    /**
     * Sets ignore unchanged counts field.
     */
    public function ignoreUnchangedCounts(?bool $value): self
    {
        $this->instance->setIgnoreUnchangedCounts($value);
        return $this;
    }

    /**
     * Unsets ignore unchanged counts field.
     */
    public function unsetIgnoreUnchangedCounts(): self
    {
        $this->instance->unsetIgnoreUnchangedCounts();
        return $this;
    }

    /**
     * Initializes a new batch change inventory request object.
     */
    public function build(): BatchChangeInventoryRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
