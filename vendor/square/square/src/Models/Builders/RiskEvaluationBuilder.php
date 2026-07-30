<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RiskEvaluation;

/**
 * Builder for model RiskEvaluation
 *
 * @see RiskEvaluation
 */
class RiskEvaluationBuilder
{
    /**
     * @var RiskEvaluation
     */
    private $instance;

    private function __construct(RiskEvaluation $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new risk evaluation Builder object.
     */
    public static function init(): self
    {
        return new self(new RiskEvaluation());
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
     * Sets risk level field.
     */
    public function riskLevel(?string $value): self
    {
        $this->instance->setRiskLevel($value);
        return $this;
    }

    /**
     * Initializes a new risk evaluation object.
     */
    public function build(): RiskEvaluation
    {
        return CoreHelper::clone($this->instance);
    }
}
