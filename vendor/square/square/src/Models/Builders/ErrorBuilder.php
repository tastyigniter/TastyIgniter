<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Error;

/**
 * Builder for model Error
 *
 * @see Error
 */
class ErrorBuilder
{
    /**
     * @var Error
     */
    private $instance;

    private function __construct(Error $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new error Builder object.
     */
    public static function init(string $category, string $code): self
    {
        return new self(new Error($category, $code));
    }

    /**
     * Sets detail field.
     */
    public function detail(?string $value): self
    {
        $this->instance->setDetail($value);
        return $this;
    }

    /**
     * Sets field field.
     */
    public function field(?string $value): self
    {
        $this->instance->setField($value);
        return $this;
    }

    /**
     * Initializes a new error object.
     */
    public function build(): Error
    {
        return CoreHelper::clone($this->instance);
    }
}
