<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListLoyaltyProgramsResponse;

/**
 * Builder for model ListLoyaltyProgramsResponse
 *
 * @see ListLoyaltyProgramsResponse
 */
class ListLoyaltyProgramsResponseBuilder
{
    /**
     * @var ListLoyaltyProgramsResponse
     */
    private $instance;

    private function __construct(ListLoyaltyProgramsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list loyalty programs response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListLoyaltyProgramsResponse());
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
     * Sets programs field.
     */
    public function programs(?array $value): self
    {
        $this->instance->setPrograms($value);
        return $this;
    }

    /**
     * Initializes a new list loyalty programs response object.
     */
    public function build(): ListLoyaltyProgramsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
