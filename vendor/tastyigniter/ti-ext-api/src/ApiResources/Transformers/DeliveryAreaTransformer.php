<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Local\Models\LocationArea;
use League\Fractal\TransformerAbstract;

class DeliveryAreaTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(LocationArea $deliveryArea): array
    {
        return $this->mergesIdAttribute($deliveryArea);
    }
}
