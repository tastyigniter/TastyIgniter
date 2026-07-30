<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UpdateItemModifierListsRequest;

/**
 * Builder for model UpdateItemModifierListsRequest
 *
 * @see UpdateItemModifierListsRequest
 */
class UpdateItemModifierListsRequestBuilder
{
    /**
     * @var UpdateItemModifierListsRequest
     */
    private $instance;

    private function __construct(UpdateItemModifierListsRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new update item modifier lists request Builder object.
     */
    public static function init(array $itemIds): self
    {
        return new self(new UpdateItemModifierListsRequest($itemIds));
    }

    /**
     * Sets modifier lists to enable field.
     */
    public function modifierListsToEnable(?array $value): self
    {
        $this->instance->setModifierListsToEnable($value);
        return $this;
    }

    /**
     * Unsets modifier lists to enable field.
     */
    public function unsetModifierListsToEnable(): self
    {
        $this->instance->unsetModifierListsToEnable();
        return $this;
    }

    /**
     * Sets modifier lists to disable field.
     */
    public function modifierListsToDisable(?array $value): self
    {
        $this->instance->setModifierListsToDisable($value);
        return $this;
    }

    /**
     * Unsets modifier lists to disable field.
     */
    public function unsetModifierListsToDisable(): self
    {
        $this->instance->unsetModifierListsToDisable();
        return $this;
    }

    /**
     * Initializes a new update item modifier lists request object.
     */
    public function build(): UpdateItemModifierListsRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
