<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1ListSettlementsResponse;

/**
 * Builder for model V1ListSettlementsResponse
 *
 * @see V1ListSettlementsResponse
 */
class V1ListSettlementsResponseBuilder
{
    /**
     * @var V1ListSettlementsResponse
     */
    private $instance;

    private function __construct(V1ListSettlementsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 list settlements response Builder object.
     */
    public static function init(): self
    {
        return new self(new V1ListSettlementsResponse());
    }

    /**
     * Sets items field.
     */
    public function items(?array $value): self
    {
        $this->instance->setItems($value);
        return $this;
    }

    /**
     * Initializes a new v1 list settlements response object.
     */
    public function build(): V1ListSettlementsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
