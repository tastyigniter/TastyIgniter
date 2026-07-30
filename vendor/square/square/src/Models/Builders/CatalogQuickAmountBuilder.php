<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogQuickAmount;
use Square\Models\Money;

/**
 * Builder for model CatalogQuickAmount
 *
 * @see CatalogQuickAmount
 */
class CatalogQuickAmountBuilder
{
    /**
     * @var CatalogQuickAmount
     */
    private $instance;

    private function __construct(CatalogQuickAmount $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog quick amount Builder object.
     */
    public static function init(string $type, Money $amount): self
    {
        return new self(new CatalogQuickAmount($type, $amount));
    }

    /**
     * Sets score field.
     */
    public function score(?int $value): self
    {
        $this->instance->setScore($value);
        return $this;
    }

    /**
     * Unsets score field.
     */
    public function unsetScore(): self
    {
        $this->instance->unsetScore();
        return $this;
    }

    /**
     * Sets ordinal field.
     */
    public function ordinal(?int $value): self
    {
        $this->instance->setOrdinal($value);
        return $this;
    }

    /**
     * Unsets ordinal field.
     */
    public function unsetOrdinal(): self
    {
        $this->instance->unsetOrdinal();
        return $this;
    }

    /**
     * Initializes a new catalog quick amount object.
     */
    public function build(): CatalogQuickAmount
    {
        return CoreHelper::clone($this->instance);
    }
}
