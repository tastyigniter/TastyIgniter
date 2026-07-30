<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CustomerCreationSourceFilter;
use Square\Models\CustomerCustomAttributeFilters;
use Square\Models\CustomerFilter;
use Square\Models\CustomerTextFilter;
use Square\Models\FilterValue;
use Square\Models\TimeRange;

/**
 * Builder for model CustomerFilter
 *
 * @see CustomerFilter
 */
class CustomerFilterBuilder
{
    /**
     * @var CustomerFilter
     */
    private $instance;

    private function __construct(CustomerFilter $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new customer filter Builder object.
     */
    public static function init(): self
    {
        return new self(new CustomerFilter());
    }

    /**
     * Sets creation source field.
     */
    public function creationSource(?CustomerCreationSourceFilter $value): self
    {
        $this->instance->setCreationSource($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?TimeRange $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets updated at field.
     */
    public function updatedAt(?TimeRange $value): self
    {
        $this->instance->setUpdatedAt($value);
        return $this;
    }

    /**
     * Sets email address field.
     */
    public function emailAddress(?CustomerTextFilter $value): self
    {
        $this->instance->setEmailAddress($value);
        return $this;
    }

    /**
     * Sets phone number field.
     */
    public function phoneNumber(?CustomerTextFilter $value): self
    {
        $this->instance->setPhoneNumber($value);
        return $this;
    }

    /**
     * Sets reference id field.
     */
    public function referenceId(?CustomerTextFilter $value): self
    {
        $this->instance->setReferenceId($value);
        return $this;
    }

    /**
     * Sets group ids field.
     */
    public function groupIds(?FilterValue $value): self
    {
        $this->instance->setGroupIds($value);
        return $this;
    }

    /**
     * Sets custom attribute field.
     */
    public function customAttribute(?CustomerCustomAttributeFilters $value): self
    {
        $this->instance->setCustomAttribute($value);
        return $this;
    }

    /**
     * Sets segment ids field.
     */
    public function segmentIds(?FilterValue $value): self
    {
        $this->instance->setSegmentIds($value);
        return $this;
    }

    /**
     * Initializes a new customer filter object.
     */
    public function build(): CustomerFilter
    {
        return CoreHelper::clone($this->instance);
    }
}
