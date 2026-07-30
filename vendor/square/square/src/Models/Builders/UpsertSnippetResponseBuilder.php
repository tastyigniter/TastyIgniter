<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Snippet;
use Square\Models\UpsertSnippetResponse;

/**
 * Builder for model UpsertSnippetResponse
 *
 * @see UpsertSnippetResponse
 */
class UpsertSnippetResponseBuilder
{
    /**
     * @var UpsertSnippetResponse
     */
    private $instance;

    private function __construct(UpsertSnippetResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new upsert snippet response Builder object.
     */
    public static function init(): self
    {
        return new self(new UpsertSnippetResponse());
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
     * Initializes a new upsert snippet response object.
     */
    public function build(): UpsertSnippetResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
