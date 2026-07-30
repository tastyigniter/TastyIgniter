<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListGiftCardActivitiesRequest;

/**
 * Builder for model ListGiftCardActivitiesRequest
 *
 * @see ListGiftCardActivitiesRequest
 */
class ListGiftCardActivitiesRequestBuilder
{
    /**
     * @var ListGiftCardActivitiesRequest
     */
    private $instance;

    private function __construct(ListGiftCardActivitiesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list gift card activities request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListGiftCardActivitiesRequest());
    }

    /**
     * Sets gift card id field.
     */
    public function giftCardId(?string $value): self
    {
        $this->instance->setGiftCardId($value);
        return $this;
    }

    /**
     * Unsets gift card id field.
     */
    public function unsetGiftCardId(): self
    {
        $this->instance->unsetGiftCardId();
        return $this;
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Unsets type field.
     */
    public function unsetType(): self
    {
        $this->instance->unsetType();
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
     * Initializes a new list gift card activities request object.
     */
    public function build(): ListGiftCardActivitiesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
