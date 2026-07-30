<?php

namespace Mollie\Api\Resources;

class RouteCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "route";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Route($this->client);
    }
}
