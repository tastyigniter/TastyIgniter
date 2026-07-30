<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveOrderCustomAttributeDefinitionRequest;

/**
 * Builder for model RetrieveOrderCustomAttributeDefinitionRequest
 *
 * @see RetrieveOrderCustomAttributeDefinitionRequest
 */
class RetrieveOrderCustomAttributeDefinitionRequestBuilder
{
    /**
     * @var RetrieveOrderCustomAttributeDefinitionRequest
     */
    private $instance;

    private function __construct(RetrieveOrderCustomAttributeDefinitionRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve order custom attribute definition request Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveOrderCustomAttributeDefinitionRequest());
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
     * Initializes a new retrieve order custom attribute definition request object.
     */
    public function build(): RetrieveOrderCustomAttributeDefinitionRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
