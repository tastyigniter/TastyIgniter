<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\User\Models\Address;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'country',
    ];

    public function transform(Address $address): array
    {
        return $this->mergesIdAttribute($address);
    }

    public function includeCountry(Address $address): ?Item
    {
        return $address->country ? $this->item($address->country, new CountryTransformer, 'countries') : null;
    }
}
