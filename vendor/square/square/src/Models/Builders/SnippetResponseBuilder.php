<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Snippet;
use Square\Models\SnippetResponse;

/**
 * Builder for model SnippetResponse
 *
 * @see SnippetResponse
 */
class SnippetResponseBuilder
{
    /**
     * @var SnippetResponse
     */
    private $instance;

    private function __construct(SnippetResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new snippet response Builder object.
     */
    public static function init(): self
    {
        return new self(new SnippetResponse());
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
     * Initializes a new snippet response object.
     */
    public function build(): SnippetResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
