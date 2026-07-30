<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveLocationCustomAttributeDefinitionRequest;

/**
 * Builder for model RetrieveLocationCustomAttributeDefinitionRequest
 *
 * @see RetrieveLocationCustomAttributeDefinitionRequest
 */
class RetrieveLocationCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var RetrieveLocationCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(RetrieveLocationCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve location custom attribute definition request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveLocationCustomAttributeDefinitionRequest());
    }

    /**
     * Sets version field.
     */
    public function version(?int $value): self
    {
        $this->instance->setVersion($value);
        return $this;
    }

    /**
     * Initializes a new retrieve location custom attribute definition request object.
     */
    public function build(): RetrieveLocationCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
