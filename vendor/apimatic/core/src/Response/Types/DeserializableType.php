<?php

namespace Core\Response\Types;

use Closure;
use Core\Response\Context;
use Throwable;

class DeserializableType
{
    /**
     * @var callable|null
     */
    private $deserializerMethod;

    /**
     * Sets deserializer method to the one provided.
     */
    public function setDeserializerMethod(callable $deserializerMethod): void
    {
        $this->deserializerMethod = $deserializerMethod;
    }

    /**
     * Returns the deserializer method if already set.
     */
    public function getFrom(Context $context)
    {
        if (is_null($this->deserializerMethod)) {
            return null;
        }
        try {
            return Closure::fromCallable($this->deserializerMethod)($context->getResponse()->getBody());
        } catch (Throwable $t) {
            throw $context->toApiException($t->getMessage());
        }
    }
}
