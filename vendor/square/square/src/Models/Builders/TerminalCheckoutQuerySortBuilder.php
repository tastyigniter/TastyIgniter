<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TerminalCheckoutQuerySort;

/**
 * Builder for model TerminalCheckoutQuerySort
 *
 * @see TerminalCheckoutQuerySort
 */
class TerminalCheckoutQuerySortBuilder
{
    /**
     * @var TerminalCheckoutQuerySort
     */
    private $instance;

    private function __construct(TerminalCheckoutQuerySort $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal checkout query sort Builder object.
     */
    public static function init(): self
    {
        return new self(new TerminalCheckoutQuerySort());
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
     * Initializes a new terminal checkout query sort object.
     */
    public function build(): TerminalCheckoutQuerySort
    {
        return CoreHelper::clone($this->instance);
    }
}
