<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListTeamMemberWagesRequest;

/**
 * Builder for model ListTeamMemberWagesRequest
 *
 * @see ListTeamMemberWagesRequest
 */
class ListTeamMemberWagesRequestBuilder
{
    /**
     * @var ListTeamMemberWagesRequest
     */
    private $instance;

    private function __construct(ListTeamMemberWagesRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list team member wages request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListTeamMemberWagesRequest());
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
     * Unsets team member id field.
     */
    public function unsetTeamMemberId(): self
    {
        $this->instance->unsetTeamMemberId();
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
     * Initializes a new list team member wages request object.
     */
    public function build(): ListTeamMemberWagesRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
