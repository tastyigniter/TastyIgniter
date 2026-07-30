<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPaymentRefundsRequest;

/**
 * Builder for model ListPaymentRefundsRequest
 *
 * @see ListPaymentRefundsRequest
 */
class ListPaymentRefundsRequestBuilder
{
    /**
     * @var ListPaymentRefundsRequest
     */
    private $instance;

    private function __construct(ListPaymentRefundsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payment refunds request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPaymentRefundsRequest());
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
     * Sets sort order field.
     */
    public function sortOrder(?string $value): self
    {
        $this->instance->setSortOrder($value);
        return $this;
    }

    /**
     * Unsets sort order field.
     */
    public function unsetSortOrder(): self
    {
        $this->instance->unsetSortOrder();
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
     * Sets location id field.
     */
    public function locationId(?string $value): self
    {
        $this->instance->setLocationId($value);
        return $this;
    }

    /**
     * Unsets location id field.
     */
    public function unsetLocationId(): self
    {
        $this->instance->unsetLocationId();
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Unsets status field.
     */
    public function unsetStatus(): self
    {
        $this->instance->unsetStatus();
        return $this;
    }

    /**
     * Sets source type field.
     */
    public function sourceType(?string $value): self
    {
        $this->instance->setSourceType($value);
        return $this;
    }

    /**
     * Unsets source type field.
     */
    public function unsetSourceType(): self
    {
        $this->instance->unsetSourceType();
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
     * Initializes a new list payment refunds request object.
     */
    public function build(): ListPaymentRefundsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
