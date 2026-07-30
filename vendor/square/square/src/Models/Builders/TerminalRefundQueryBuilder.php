<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TerminalRefundQuery;
use Square\Models\TerminalRefundQueryFilter;
use Square\Models\TerminalRefundQuerySort;

/**
 * Builder for model TerminalRefundQuery
 *
 * @see TerminalRefundQuery
 */
class TerminalRefundQueryBuilder
{
    /**
     * @var TerminalRefundQuery
     */
    private $instance;

    private function __construct(TerminalRefundQuery $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal refund query Builder object.
     */
    public static function init(): self
    {
        return new self(new TerminalRefundQuery());
    }

    /**
     * Sets filter field.
     */
    public function filter(?TerminalRefundQueryFilter $value): self
    {
        $this->instance->setFilter($value);
        return $this;
    }

    /**
     * Sets sort field.
     */
    public function sort(?TerminalRefundQuerySort $value): self
    {
        $this->instance->setSort($value);
        return $this;
    }

    /**
     * Initializes a new terminal refund query object.
     */
    public function build(): TerminalRefundQuery
    {
        return CoreHelper::clone($this->instance);
    }
}
