<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateDisputeEvidenceFileRequest;

/**
 * Builder for model CreateDisputeEvidenceFileRequest
 *
 * @see CreateDisputeEvidenceFileRequest
 */
class CreateDisputeEvidenceFileRequestBuilder
{
    /**
     * @var CreateDisputeEvidenceFileRequest
     */
    private $instance;

    private function __construct(CreateDisputeEvidenceFileRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create dispute evidence file request Builder object.
     */
    public static function init(string $idempotencyKey): self
    {
        return new self(new CreateDisputeEvidenceFileRequest($idempotencyKey));
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
     * Initializes a new create dispute evidence file request object.
     */
    public function build(): CreateDisputeEvidenceFileRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
