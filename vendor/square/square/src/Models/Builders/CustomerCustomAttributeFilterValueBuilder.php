<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerAddressFilter;
use Square\Models\CustomerCustomAttributeFilterValue;
use Square\Models\CustomerTextFilter;
use Square\Models\FilterValue;
use Square\Models\FloatNumberRange;
use Square\Models\TimeRange;

/**
 * Builder for model CustomerCustomAttributeFilterValue
 *
 * @see CustomerCustomAttributeFilterValue
 */
class CustomerCustomAttributeFilterValueBuilder
{
    /**
     * @var CustomerCustomAttributeFilterValue
     */
    private $instance;

    private function __construct(CustomerCustomAttributeFilterValue $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer custom attribute filter value Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerCustomAttributeFilterValue());
    }

    /**
     * Sets email field.
     */
    public function email(?CustomerTextFilter $value): self
    {
        $this->instance->setEmail($value);
        return $this;
    }

    /**
     * Sets phone field.
     */
    public function phone(?CustomerTextFilter $value): self
    {
        $this->instance->setPhone($value);
        return $this;
    }

    /**
     * Sets text field.
     */
    public function text(?CustomerTextFilter $value): self
    {
        $this->instance->setText($value);
        return $this;
    }

    /**
     * Sets selection field.
     */
    public function selection(?FilterValue $value): self
    {
        $this->instance->setSelection($value);
        return $this;
    }

    /**
     * Sets date field.
     */
    public function date(?TimeRange $value): self
    {
        $this->instance->setDate($value);
        return $this;
    }

    /**
     * Sets number field.
     */
    public function number(?FloatNumberRange $value): self
    {
        $this->instance->setNumber($value);
        return $this;
    }

    /**
     * Sets boolean field.
     */
    public function boolean(?bool $value): self
    {
        $this->instance->setBoolean($value);
        return $this;
    }

    /**
     * Unsets boolean field.
     */
    public function unsetBoolean(): self
    {
        $this->instance->unsetBoolean();
        return $this;
    }

    /**
     * Sets address field.
     */
    public function address(?CustomerAddressFilter $value): self
    {
        $this->instance->setAddress($value);
        return $this;
    }

    /**
     * Initializes a new customer custom attribute filter value object.
     */
    public function build(): CustomerCustomAttributeFilterValue
    {
        return CoreHelper::clone($this->instance);
    }
}
