<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveOrderCustomAttributeRequest;

/**
 * Builder for model RetrieveOrderCustomAttributeRequest
 *
 * @see RetrieveOrderCustomAttributeRequest
 */
class RetrieveOrderCustomAttributeRequestBuilder
{
    /**
     * @var RetrieveOrderCustomAttributeRequest
     */
    private $instance;

    private function __construct(RetrieveOrderCustomAttributeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve order custom attribute request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveOrderCustomAttributeRequest());
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
     * Initializes a new retrieve order custom attribute request object.
     */
    public function build(): RetrieveOrderCustomAttributeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
