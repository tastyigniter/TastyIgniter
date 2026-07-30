<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListGiftCardActivitiesResponse;

/**
 * Builder for model ListGiftCardActivitiesResponse
 *
 * @see ListGiftCardActivitiesResponse
 */
class ListGiftCardActivitiesResponseBuilder
{
    /**
     * @var ListGiftCardActivitiesResponse
     */
    private $instance;

    private function __construct(ListGiftCardActivitiesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list gift card activities response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListGiftCardActivitiesResponse());
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
     * Sets gift card activities field.
     */
    public function giftCardActivities(?array $value): self
    {
        $this->instance->setGiftCardActivities($value);
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
     * Initializes a new list gift card activities response object.
     */
    public function build(): ListGiftCardActivitiesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
