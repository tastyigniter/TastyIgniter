<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateTerminalActionResponse;
use Square\Models\TerminalAction;

/**
 * Builder for model CreateTerminalActionResponse
 *
 * @see CreateTerminalActionResponse
 */
class CreateTerminalActionResponseBuilder
{
    /**
     * @var CreateTerminalActionResponse
     */
    private $instance;

    private function __construct(CreateTerminalActionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create terminal action response Builder object.
     */
    public static function init(): self
    {
        return new self(new CreateTerminalActionResponse());
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
     * Initializes a new create terminal action response object.
     */
    public function build(): CreateTerminalActionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
