<?php

namespace Mollie\Api\Resources;

class ProfileCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "profiles";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Profile($this->client);
    }
}
