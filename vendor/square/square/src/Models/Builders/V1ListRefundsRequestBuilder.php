<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1ListRefundsRequest;

/**
 * Builder for model V1ListRefundsRequest
 *
 * @see V1ListRefundsRequest
 */
class V1ListRefundsRequestBuilder
{
    /**
     * @var V1ListRefundsRequest
     */
    private $instance;

    private function __construct(V1ListRefundsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 list refunds request Builder object.
     */
    public static function init(): self
    {
        return new self(new V1ListRefundsRequest());
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
     * Sets begin time field.
     */
    public function beginTime(?string $value): self
    {
        $this->instance->setBeginTime($value);
        return $this;
    }

    /**
     * Unsets begin time field.
     */
    public function unsetBeginTime(): self
    {
        $this->instance->unsetBeginTime();
        return $this;
    }

    /**
     * Sets end time field.
     */
    public function endTime(?string $value): self
    {
        $this->instance->setEndTime($value);
        return $this;
    }

    /**
     * Unsets end time field.
     */
    public function unsetEndTime(): self
    {
        $this->instance->unsetEndTime();
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
     * Initializes a new v1 list refunds request object.
     */
    public function build(): V1ListRefundsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
