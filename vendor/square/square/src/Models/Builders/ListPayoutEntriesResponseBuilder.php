<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListPayoutEntriesResponse;

/**
 * Builder for model ListPayoutEntriesResponse
 *
 * @see ListPayoutEntriesResponse
 */
class ListPayoutEntriesResponseBuilder
{
    /**
     * @var ListPayoutEntriesResponse
     */
    private $instance;

    private function __construct(ListPayoutEntriesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list payout entries response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListPayoutEntriesResponse());
    }

    /**
     * Sets payout entries field.
     */
    public function payoutEntries(?array $value): self
    {
        $this->instance->setPayoutEntries($value);
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
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new list payout entries response object.
     */
    public function build(): ListPayoutEntriesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
