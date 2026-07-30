<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteLocationCustomAttributeResponse;

/**
 * Builder for model DeleteLocationCustomAttributeResponse
 *
 * @see DeleteLocationCustomAttributeResponse
 */
class DeleteLocationCustomAttributeResponseBuilder
{
    /**
     * @var DeleteLocationCustomAttributeResponse
     */
    private $instance;

    private function __construct(DeleteLocationCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete location custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteLocationCustomAttributeResponse());
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
     * Initializes a new delete location custom attribute response object.
     */
    public function build(): DeleteLocationCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
