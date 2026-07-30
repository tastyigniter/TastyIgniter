<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeprecatedCreateDisputeEvidenceFileRequest;

/**
 * Builder for model DeprecatedCreateDisputeEvidenceFileRequest
 *
 * @see DeprecatedCreateDisputeEvidenceFileRequest
 */
class DeprecatedCreateDisputeEvidenceFileRequestBuilder
{
    /**
     * @var DeprecatedCreateDisputeEvidenceFileRequest
     */
    private $instance;

    private function __construct(DeprecatedCreateDisputeEvidenceFileRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new deprecated create dispute evidence file request Builder object.
     */
    public static function init(string $idempotencyKey): self
    {
        return new self(new DeprecatedCreateDisputeEvidenceFileRequest($idempotencyKey));
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
     * Sets content type field.
     */
    public function contentType(?string $value): self
    {
        $this->instance->setContentType($value);
        return $this;
    }

    /**
     * Unsets content type field.
     */
    public function unsetContentType(): self
    {
        $this->instance->unsetContentType();
        return $this;
    }

    /**
     * Initializes a new deprecated create dispute evidence file request object.
     */
    public function build(): DeprecatedCreateDisputeEvidenceFileRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
