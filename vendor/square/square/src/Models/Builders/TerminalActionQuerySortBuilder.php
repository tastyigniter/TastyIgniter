<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TerminalActionQuerySort;

/**
 * Builder for model TerminalActionQuerySort
 *
 * @see TerminalActionQuerySort
 */
class TerminalActionQuerySortBuilder
{
    /**
     * @var TerminalActionQuerySort
     */
    private $instance;

    private function __construct(TerminalActionQuerySort $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new terminal action query sort Builder object.
     */
    public static function init(): self
    {
        return new self(new TerminalActionQuerySort());
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
     * Initializes a new terminal action query sort object.
     */
    public function build(): TerminalActionQuerySort
    {
        return CoreHelper::clone($this->instance);
    }
}
