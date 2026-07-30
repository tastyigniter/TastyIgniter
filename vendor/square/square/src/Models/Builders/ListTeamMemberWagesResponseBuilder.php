<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListTeamMemberWagesResponse;

/**
 * Builder for model ListTeamMemberWagesResponse
 *
 * @see ListTeamMemberWagesResponse
 */
class ListTeamMemberWagesResponseBuilder
{
    /**
     * @var ListTeamMemberWagesResponse
     */
    private $instance;

    private function __construct(ListTeamMemberWagesResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list team member wages response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListTeamMemberWagesResponse());
    }

    /**
     * Sets team member wages field.
     */
    public function teamMemberWages(?array $value): self
    {
        $this->instance->setTeamMemberWages($value);
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
     * Initializes a new list team member wages response object.
     */
    public function build(): ListTeamMemberWagesResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
