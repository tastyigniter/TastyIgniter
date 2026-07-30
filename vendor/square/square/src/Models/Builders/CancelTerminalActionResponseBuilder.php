<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CancelTerminalActionResponse;
use Square\Models\TerminalAction;

/**
 * Builder for model CancelTerminalActionResponse
 *
 * @see CancelTerminalActionResponse
 */
class CancelTerminalActionResponseBuilder
{
    /**
     * @var CancelTerminalActionResponse
     */
    private $instance;

    private function __construct(CancelTerminalActionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cancel terminal action response Builder object.
     */
    public static function init(): self
    {
        return new self(new CancelTerminalActionResponse());
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
     * Sets action field.
     */
    public function action(?TerminalAction $value): self
    {
        $this->instance->setAction($value);
        return $this;
    }

    /**
     * Initializes a new cancel terminal action response object.
     */
    public function build(): CancelTerminalActionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
