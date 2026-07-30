<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\MBreak;

/**
 * Builder for model MBreak
 *
 * @see MBreak
 */
class MBreakBuilder
{
    /**
     * @var MBreak
     */
    private $instance;

    private function __construct(MBreak $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new mbreak Builder object.
     */
    public static function init(
        string $startAt,
        string $breakTypeId,
        string $name,
        string $expectedDuration,
        bool $isPaid
    ): self {
        return new self(new MBreak($startAt, $breakTypeId, $name, $expectedDuration, $isPaid));
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets end at field.
     */
    public function endAt(?string $value): self
    {
        $this->instance->setEndAt($value);
        return $this;
    }

    /**
     * Unsets end at field.
     */
    public function unsetEndAt(): self
    {
        $this->instance->unsetEndAt();
        return $this;
    }

    /**
     * Initializes a new mbreak object.
     */
    public function build(): MBreak
    {
        return CoreHelper::clone($this->instance);
    }
}
