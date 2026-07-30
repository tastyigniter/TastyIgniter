<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeprecatedCreateDisputeEvidenceTextResponse;
use Square\Models\DisputeEvidence;

/**
 * Builder for model DeprecatedCreateDisputeEvidenceTextResponse
 *
 * @see DeprecatedCreateDisputeEvidenceTextResponse
 */
class DeprecatedCreateDisputeEvidenceTextResponseBuilder
{
    /**
     * @var DeprecatedCreateDisputeEvidenceTextResponse
     */
    private $instance;

    private function __construct(DeprecatedCreateDisputeEvidenceTextResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new deprecated create dispute evidence text response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeprecatedCreateDisputeEvidenceTextResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Sets evidence field.
     */
    public function evidence(?DisputeEvidence $value): self
    {
        $this->instance->setEvidence($value);
        return $this;
    }

    /**
     * Initializes a new deprecated create dispute evidence text response object.
     */
    public function build(): DeprecatedCreateDisputeEvidenceTextResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
