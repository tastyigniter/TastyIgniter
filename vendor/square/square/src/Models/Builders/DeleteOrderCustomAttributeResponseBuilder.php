<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteOrderCustomAttributeResponse;

/**
 * Builder for model DeleteOrderCustomAttributeResponse
 *
 * @see DeleteOrderCustomAttributeResponse
 */
class DeleteOrderCustomAttributeResponseBuilder
{
    /**
     * @var DeleteOrderCustomAttributeResponse
     */
    private $instance;

    private function __construct(DeleteOrderCustomAttributeResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete order custom attribute response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteOrderCustomAttributeResponse());
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
     * Initializes a new delete order custom attribute response object.
     */
    public function build(): DeleteOrderCustomAttributeResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
