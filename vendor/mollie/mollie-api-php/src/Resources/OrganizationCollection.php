<?php

namespace Mollie\Api\Resources;

class OrganizationCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "organizations";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Organization($this->client);
    }
}
