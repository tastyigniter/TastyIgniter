<?php

namespace Mollie\Api\Resources;

class MandateCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return "mandates";
    }

    /**
     * @return BaseResource
     */
    protected function createResourceObject()
    {
        return new Mandate($this->client);
    }

    /**
     * @param string $status
     * @return array|\Mollie\Api\Resources\MandateCollection
     */
    public function whereStatus($status)
    {
        $collection = new self($this->client, 0, $this->_links);

        foreach ($this as $item) {
            if ($item->status === $status) {
                $collection[] = $item;
                $collection->count++;
            }
        }

        return $collection;
    }
}
