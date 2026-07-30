<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Local\Models\LocationSettings;
use League\Fractal\TransformerAbstract;

class LocationSettingsTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(LocationSettings $locationSettings): array
    {
        return $this->mergesIdAttribute($locationSettings);
    }
}
