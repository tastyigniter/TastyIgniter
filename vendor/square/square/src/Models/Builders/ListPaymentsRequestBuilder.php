<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPaymentsRequest;

/**
 * Builder for model ListPaymentsRequest
 *
 * @see ListPaymentsRequest
 */
class ListPaymentsRequestBuilder
{
    /**
     * @var ListPaymentsRequest
     */
    private $instance;

    private function __construct(ListPaymentsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payments request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPaymentsRequest());
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
     * Sets total field.
     */
    public function total(?int $value): self
    {
        $this->instance->setTotal($value);
        return $this;
    }

    /**
     * Unsets total field.
     */
    public function unsetTotal(): self
    {
        $this->instance->unsetTotal();
        return $this;
    }

    /**
     * Sets last 4 field.
     */
    public function last4(?string $value): self
    {
        $this->instance->setLast4($value);
        return $this;
    }

    /**
     * Unsets last 4 field.
     */
    public function unsetLast4(): self
    {
        $this->instance->unsetLast4();
        return $this;
    }

    /**
     * Sets card brand field.
     */
    public function cardBrand(?string $value): self
    {
        $this->instance->setCardBrand($value);
        return $this;
    }

    /**
     * Unsets card brand field.
     */
    public function unsetCardBrand(): self
    {
        $this->instance->unsetCardBrand();
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
     * Initializes a new list payments request object.
     */
    public function build(): ListPaymentsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
