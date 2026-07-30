<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\DeleteLocationCustomAttributeDefinitionResponse;

/**
 * Builder for model DeleteLocationCustomAttributeDefinitionResponse
 *
 * @see DeleteLocationCustomAttributeDefinitionResponse
 */
class DeleteLocationCustomAttributeDefinitionResponseBuilder
{
    /**
     * @var DeleteLocationCustomAttributeDefinitionResponse
     */
    private $instance;

    private function __construct(DeleteLocationCustomAttributeDefinitionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new delete location custom attribute definition response Builder object.
     */
    public static function init(): self
    {
        return new self(new DeleteLocationCustomAttributeDefinitionResponse());
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
     * Initializes a new delete location custom attribute definition response object.
     */
    public function build(): DeleteLocationCustomAttributeDefinitionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
