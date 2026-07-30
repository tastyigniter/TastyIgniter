<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1ListOrdersResponse;

/**
 * Builder for model V1ListOrdersResponse
 *
 * @see V1ListOrdersResponse
 */
class V1ListOrdersResponseBuilder
{
    /**
     * @var V1ListOrdersResponse
     */
    private $instance;

    private function __construct(V1ListOrdersResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 list orders response Builder object.
     */
    public static function init(): self
    {
        return new self(new V1ListOrdersResponse());
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
     * Initializes a new v1 list orders response object.
     */
    public function build(): V1ListOrdersResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
