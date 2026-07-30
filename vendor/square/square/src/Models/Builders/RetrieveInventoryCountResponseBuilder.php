<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveInventoryCountResponse;

/**
 * Builder for model RetrieveInventoryCountResponse
 *
 * @see RetrieveInventoryCountResponse
 */
class RetrieveInventoryCountResponseBuilder
{
    /**
     * @var RetrieveInventoryCountResponse
     */
    private $instance;

    private function __construct(RetrieveInventoryCountResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve inventory count response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveInventoryCountResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets counts field.
     */
    public function counts(?array $value): self
    {
        $this->instance->setCounts($value);
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
     * Initializes a new retrieve inventory count response object.
     */
    public function build(): RetrieveInventoryCountResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
