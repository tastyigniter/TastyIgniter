<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\V1OrderHistoryEntry;

/**
 * Builder for model V1OrderHistoryEntry
 *
 * @see V1OrderHistoryEntry
 */
class V1OrderHistoryEntryBuilder
{
    /**
     * @var V1OrderHistoryEntry
     */
    private $instance;

    private function __construct(V1OrderHistoryEntry $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new v1 order history entry Builder object.
     */
    public static function init(): self
    {
        return new self(new V1OrderHistoryEntry());
    }

    /**
     * Sets action field.
     */
    public function action(?string $value): self
    {
        $this->instance->setAction($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Initializes a new v1 order history entry object.
     */
    public function build(): V1OrderHistoryEntry
    {
        return CoreHelper::clone($this->instance);
    }
}
