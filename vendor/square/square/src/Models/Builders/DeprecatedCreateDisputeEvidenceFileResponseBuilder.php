<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeprecatedCreateDisputeEvidenceFileResponse;
use Square\Models\DisputeEvidence;

/**
 * Builder for model DeprecatedCreateDisputeEvidenceFileResponse
 *
 * @see DeprecatedCreateDisputeEvidenceFileResponse
 */
class DeprecatedCreateDisputeEvidenceFileResponseBuilder
{
    /**
     * @var DeprecatedCreateDisputeEvidenceFileResponse
     */
    private $instance;

    private function __construct(DeprecatedCreateDisputeEvidenceFileResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new deprecated create dispute evidence file response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeprecatedCreateDisputeEvidenceFileResponse());
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
     * Initializes a new deprecated create dispute evidence file response object.
     */
    public function build(): DeprecatedCreateDisputeEvidenceFileResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
