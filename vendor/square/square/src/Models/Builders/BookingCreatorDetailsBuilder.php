<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BookingCreatorDetails;

/**
 * Builder for model BookingCreatorDetails
 *
 * @see BookingCreatorDetails
 */
class BookingCreatorDetailsBuilder
{
    /**
     * @var BookingCreatorDetails
     */
    private $instance;

    private function __construct(BookingCreatorDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new booking creator details Builder object.
     */
    public static function init(): self
    {
        return new self(new BookingCreatorDetails());
    }

    /**
     * Sets creator type field.
     */
    public function creatorType(?string $value): self
    {
        $this->instance->setCreatorType($value);
        return $this;
    }

    /**
     * Sets team member id field.
     */
    public function teamMemberId(?string $value): self
    {
        $this->instance->setTeamMemberId($value);
        return $this;
    }

    /**
     * Sets customer id field.
     */
    public function customerId(?string $value): self
    {
        $this->instance->setCustomerId($value);
        return $this;
    }

    /**
     * Initializes a new booking creator details object.
     */
    public function build(): BookingCreatorDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
