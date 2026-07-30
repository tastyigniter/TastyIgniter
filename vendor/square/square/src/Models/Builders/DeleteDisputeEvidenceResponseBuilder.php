<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteDisputeEvidenceResponse;

/**
 * Builder for model DeleteDisputeEvidenceResponse
 *
 * @see DeleteDisputeEvidenceResponse
 */
class DeleteDisputeEvidenceResponseBuilder
{
    /**
     * @var DeleteDisputeEvidenceResponse
     */
    private $instance;

    private function __construct(DeleteDisputeEvidenceResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete dispute evidence response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteDisputeEvidenceResponse());
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
     * Initializes a new delete dispute evidence response object.
     */
    public function build(): DeleteDisputeEvidenceResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
