<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\GetTerminalActionResponse;
use Square\Models\TerminalAction;

/**
 * Builder for model GetTerminalActionResponse
 *
 * @see GetTerminalActionResponse
 */
class GetTerminalActionResponseBuilder
{
    /**
     * @var GetTerminalActionResponse
     */
    private $instance;

    private function __construct(GetTerminalActionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new get terminal action response Builder object.
     */
    public static function init(): self
    {
        return new self(new GetTerminalActionResponse());
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
     * Initializes a new get terminal action response object.
     */
    public function build(): GetTerminalActionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
