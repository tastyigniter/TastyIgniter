<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListDisputeEvidenceRequest;

/**
 * Builder for model ListDisputeEvidenceRequest
 *
 * @see ListDisputeEvidenceRequest
 */
class ListDisputeEvidenceRequestBuilder
{
    /**
     * @var ListDisputeEvidenceRequest
     */
    private $instance;

    private function __construct(ListDisputeEvidenceRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list dispute evidence request Builder object.
     */
    public static function init(): self
    {
        return new self(new ListDisputeEvidenceRequest());
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Unsets cursor field.
     */
    public function unsetCursor(): self
    {
        $this->instance->unsetCursor();
        return $this;
    }

    /**
     * Initializes a new list dispute evidence request object.
     */
    public function build(): ListDisputeEvidenceRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
