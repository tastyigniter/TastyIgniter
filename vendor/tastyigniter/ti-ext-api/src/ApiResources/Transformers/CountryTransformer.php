<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\System\Models\Country;
use League\Fractal\TransformerAbstract;

class CountryTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(Country $country): array
    {
        return $this->mergesIdAttribute($country);
    }
}
