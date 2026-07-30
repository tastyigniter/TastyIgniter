<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CashDrawerShiftEvent;
use Square\Models\Money;

/**
 * Builder for model CashDrawerShiftEvent
 *
 * @see CashDrawerShiftEvent
 */
class CashDrawerShiftEventBuilder
{
    /**
     * @var CashDrawerShiftEvent
     */
    private $instance;

    private function __construct(CashDrawerShiftEvent $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cash drawer shift event Builder object.
     */
    public static function init(): self
    {
        return new self(new CashDrawerShiftEvent());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets employee id field.
     */
    public function employeeId(?string $value): self
    {
        $this->instance->setEmployeeId($value);
        return $this;
    }

    /**
     * Unsets employee id field.
     */
    public function unsetEmployeeId(): self
    {
        $this->instance->unsetEmployeeId();
        return $this;
    }

    /**
     * Sets event type field.
     */
    public function eventType(?string $value): self
    {
        $this->instance->setEventType($value);
        return $this;
    }

    /**
     * Sets event money field.
     */
    public function eventMoney(?Money $value): self
    {
        $this->instance->setEventMoney($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets description field.
     */
    public function description(?string $value): self
    {
        $this->instance->setDescription($value);
        return $this;
    }

    /**
     * Unsets description field.
     */
    public function unsetDescription(): self
    {
        $this->instance->unsetDescription();
        return $this;
    }

    /**
     * Initializes a new cash drawer shift event object.
     */
    public function build(): CashDrawerShiftEvent
    {
        return CoreHelper::clone($this->instance);
    }
}
