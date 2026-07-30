<?php

declare(strict_types=1);

namespace Core\Response\Types;

use Core\Response\Context;
use Exception;

class ResponseMultiType
{
    /**
     * @var string|null
     */
    private $typeGroup;

    /**
     * @var string[]
     */
    private $deserializers = [];

    /**
     * Sets type group to the one provided.
     */
    public function setTypeGroup(string $typeGroup): void
    {
        $this->typeGroup = $typeGroup;
    }

    /**
     * Sets deserializers array to the one provided.
     */
    public function setDeserializers(array $deserializers): void
    {
        $this->deserializers = $deserializers;
    }

    /**
     * Returns ResponseMultiType from the body of response within the context provided.
     */
    public function getFrom(Context $context)
    {
        if (is_null($this->typeGroup)) {
            return null;
        }
        $responseBody = $context->getResponse()->getBody();
        try {
            return $context->getJsonHelper()->mapTypes($responseBody, $this->typeGroup, $this->deserializers);
        } catch (Exception $e) {
            throw $context->toApiException($e->getMessage());
        }
    }
}
