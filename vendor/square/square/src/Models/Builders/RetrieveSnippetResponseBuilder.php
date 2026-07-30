<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveSnippetResponse;
use Square\Models\Snippet;

/**
 * Builder for model RetrieveSnippetResponse
 *
 * @see RetrieveSnippetResponse
 */
class RetrieveSnippetResponseBuilder
{
    /**
     * @var RetrieveSnippetResponse
     */
    private $instance;

    private function __construct(RetrieveSnippetResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve snippet response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveSnippetResponse());
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
     * Sets snippet field.
     */
    public function snippet(?Snippet $value): self
    {
        $this->instance->setSnippet($value);
        return $this;
    }

    /**
     * Initializes a new retrieve snippet response object.
     */
    public function build(): RetrieveSnippetResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
