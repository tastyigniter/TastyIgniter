<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1ListOrdersRequest;

/**
 * Builder for model V1ListOrdersRequest
 *
 * @see V1ListOrdersRequest
 */
class V1ListOrdersRequestBuilder
{
    /**
     * @var V1ListOrdersRequest
     */
    private $instance;

    private function __construct(V1ListOrdersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 list orders request Builder object.
     */
    public static function init(): self
    {
        return new self(new V1ListOrdersRequest());
    }

    /**
     * Sets order field.
     */
    public function order(?string $value): self
    {
        $this->instance->setOrder($value);
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
     * Sets batch token field.
     */
    public function batchToken(?string $value): self
    {
        $this->instance->setBatchToken($value);
        return $this;
    }

    /**
     * Unsets batch token field.
     */
    public function unsetBatchToken(): self
    {
        $this->instance->unsetBatchToken();
        return $this;
    }

    /**
     * Initializes a new v1 list orders request object.
     */
    public function build(): V1ListOrdersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
