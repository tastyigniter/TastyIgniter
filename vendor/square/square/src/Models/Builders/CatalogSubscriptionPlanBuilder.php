<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogSubscriptionPlan;

/**
 * Builder for model CatalogSubscriptionPlan
 *
 * @see CatalogSubscriptionPlan
 */
class CatalogSubscriptionPlanBuilder
{
    /**
     * @var CatalogSubscriptionPlan
     */
    private $instance;

    private function __construct(CatalogSubscriptionPlan $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog subscription plan Builder object.
     */
    public static function init(string $name): self
    {
        return new self(new CatalogSubscriptionPlan($name));
    }

    /**
     * Sets phases field.
     */
    public function phases(?array $value): self
    {
        $this->instance->setPhases($value);
        return $this;
    }

    /**
     * Unsets phases field.
     */
    public function unsetPhases(): self
    {
        $this->instance->unsetPhases();
        return $this;
    }

    /**
     * Initializes a new catalog subscription plan object.
     */
    public function build(): CatalogSubscriptionPlan
    {
        return CoreHelper::clone($this->instance);
    }
}
