<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteBreakTypeResponse;

/**
 * Builder for model DeleteBreakTypeResponse
 *
 * @see DeleteBreakTypeResponse
 */
class DeleteBreakTypeResponseBuilder
{
    /**
     * @var DeleteBreakTypeResponse
     */
    private $instance;

    private function __construct(DeleteBreakTypeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete break type response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteBreakTypeResponse());
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
     * Initializes a new delete break type response object.
     */
    public function build(): DeleteBreakTypeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
