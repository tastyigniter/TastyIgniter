<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeprecatedCreateDisputeEvidenceTextRequest;

/**
 * Builder for model DeprecatedCreateDisputeEvidenceTextRequest
 *
 * @see DeprecatedCreateDisputeEvidenceTextRequest
 */
class DeprecatedCreateDisputeEvidenceTextRequestBuilder
{
    /**
     * @var DeprecatedCreateDisputeEvidenceTextRequest
     */
    private $instance;

    private function __construct(DeprecatedCreateDisputeEvidenceTextRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new deprecated create dispute evidence text request Builder object.
     */
    public static function init(string $idempotencyKey, string $evidenceText): self
    {
        return new self(new DeprecatedCreateDisputeEvidenceTextRequest($idempotencyKey, $evidenceText));
    }

    /**
     * Sets evidence type field.
     */
    public function evidenceType(?string $value): self
    {
        $this->instance->setEvidenceType($value);
        return $this;
    }

    /**
     * Initializes a new deprecated create dispute evidence text request object.
     */
    public function build(): DeprecatedCreateDisputeEvidenceTextRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
