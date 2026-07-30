<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TerminalActionQuery;
use Square\Models\TerminalActionQueryFilter;
use Square\Models\TerminalActionQuerySort;

/**
 * Builder for model TerminalActionQuery
 *
 * @see TerminalActionQuery
 */
class TerminalActionQueryBuilder
{
    /**
     * @var TerminalActionQuery
     */
    private $instance;

    private function __construct(TerminalActionQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal action query Builder object.
     */
    public static function init(): self
    {
        return new self(new TerminalActionQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?TerminalActionQueryFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Sets sort field.
     */
    public function sort(?TerminalActionQuerySort $value): self
    {
        $this->instance->setSort($value);
        return $this;
    }

    /**
     * Initializes a new terminal action query object.
     */
    public function build(): TerminalActionQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
