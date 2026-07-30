<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute;

/**
 * Builder for model BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute
 *
 * @see BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute
 */
class BulkDeleteOrderCustomAttributesRequestDeleteCustomAttributeBuilder
{
    /**
     * @var BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute
     */
    private $instance;

    private function __construct(BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new bulk delete order custom attributes request delete custom attribute Builder object.
     */
    public static function init(string $orderId): self
    {
        return new self(new BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute($orderId));
    }

    /**
     * Sets key field.
     */
    public function key(?string $value): self
    {
        $this->instance->setKey($value);
        return $this;
    }

    /**
     * Initializes a new bulk delete order custom attributes request delete custom attribute object.
     */
    public function build(): BulkDeleteOrderCustomAttributesRequestDeleteCustomAttribute
    {
        return CoreHelper::clone($this->instance);
    }
}
