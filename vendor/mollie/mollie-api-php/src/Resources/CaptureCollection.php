<?php

namespace Mollie\Api\Resources;

class CaptureCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "captures";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Capture($this->client);
    }
}
