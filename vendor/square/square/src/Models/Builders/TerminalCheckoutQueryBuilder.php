<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TerminalCheckoutQuery;
use Square\Models\TerminalCheckoutQueryFilter;
use Square\Models\TerminalCheckoutQuerySort;

/**
 * Builder for model TerminalCheckoutQuery
 *
 * @see TerminalCheckoutQuery
 */
class TerminalCheckoutQueryBuilder
{
    /**
     * @var TerminalCheckoutQuery
     */
    private $instance;

    private function __construct(TerminalCheckoutQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal checkout query Builder object.
     */
    public static function init(): self
    {
        return new self(new TerminalCheckoutQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?TerminalCheckoutQueryFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Sets sort field.
     */
    public function sort(?TerminalCheckoutQuerySort $value): self
    {
        $this->instance->setSort($value);
        return $this;
    }

    /**
     * Initializes a new terminal checkout query object.
     */
    public function build(): TerminalCheckoutQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
