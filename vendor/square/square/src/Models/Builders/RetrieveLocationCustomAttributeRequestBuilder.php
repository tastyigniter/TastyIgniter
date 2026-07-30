<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveLocationCustomAttributeRequest;

/**
 * Builder for model RetrieveLocationCustomAttributeRequest
 *
 * @see RetrieveLocationCustomAttributeRequest
 */
class RetrieveLocationCustomAttributeRequestBuilder
{
    /**
     * @var RetrieveLocationCustomAttributeRequest
     */
    private $instance;

    private function __construct(RetrieveLocationCustomAttributeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve location custom attribute request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveLocationCustomAttributeRequest());
    }

    /**
     * Sets with definition field.
     */
    public function withDefinition(?bool $value): self
    {
        $this->instance->setWithDefinition($value);
        return $this;
    }

    /**
     * Unsets with definition field.
     */
    public function unsetWithDefinition(): self
    {
        $this->instance->unsetWithDefinition();
        return $this;
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Initializes a new retrieve location custom attribute request object.
     */
    public function build(): RetrieveLocationCustomAttributeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
