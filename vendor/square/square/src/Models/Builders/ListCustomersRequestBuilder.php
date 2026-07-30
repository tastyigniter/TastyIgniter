<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListCustomersRequest;

/**
 * Builder for model ListCustomersRequest
 *
 * @see ListCustomersRequest
 */
class ListCustomersRequestBuilder
{
    /**
     * @var ListCustomersRequest
     */
    private $instance;

    private function __construct(ListCustomersRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list customers request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListCustomersRequest());
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
     * Sets sort field field.
     */
    public function sortField(?string $value): self
    {
        $this->instance->setSortField($value);
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
     * Initializes a new list customers request object.
     */
    public function build(): ListCustomersRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
