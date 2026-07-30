<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\TipSettings;

/**
 * Builder for model TipSettings
 *
 * @see TipSettings
 */
class TipSettingsBuilder
{
    /**
     * @var TipSettings
     */
    private $instance;

    private function __construct(TipSettings $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new tip settings Builder object.
     */
    public static function init(): self
    {
        return new self(new TipSettings());
    }

    /**
     * Sets allow tipping field.
     */
    public function allowTipping(?bool $value): self
    {
        $this->instance->setAllowTipping($value);
        return $this;
    }

    /**
     * Unsets allow tipping field.
     */
    public function unsetAllowTipping(): self
    {
        $this->instance->unsetAllowTipping();
        return $this;
    }

    /**
     * Sets separate tip screen field.
     */
    public function separateTipScreen(?bool $value): self
    {
        $this->instance->setSeparateTipScreen($value);
        return $this;
    }

    /**
     * Unsets separate tip screen field.
     */
    public function unsetSeparateTipScreen(): self
    {
        $this->instance->unsetSeparateTipScreen();
        return $this;
    }

    /**
     * Sets custom tip field field.
     */
    public function customTipField(?bool $value): self
    {
        $this->instance->setCustomTipField($value);
        return $this;
    }

    /**
     * Unsets custom tip field field.
     */
    public function unsetCustomTipField(): self
    {
        $this->instance->unsetCustomTipField();
        return $this;
    }

    /**
     * Sets tip percentages field.
     */
    public function tipPercentages(?array $value): self
    {
        $this->instance->setTipPercentages($value);
        return $this;
    }

    /**
     * Unsets tip percentages field.
     */
    public function unsetTipPercentages(): self
    {
        $this->instance->unsetTipPercentages();
        return $this;
    }

    /**
     * Sets smart tipping field.
     */
    public function smartTipping(?bool $value): self
    {
        $this->instance->setSmartTipping($value);
        return $this;
    }

    /**
     * Unsets smart tipping field.
     */
    public function unsetSmartTipping(): self
    {
        $this->instance->unsetSmartTipping();
        return $this;
    }

    /**
     * Initializes a new tip settings object.
     */
    public function build(): TipSettings
    {
        return CoreHelper::clone($this->instance);
    }
}
