<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Admin\Models\StatusHistory;
use Igniter\Api\Traits\MergesIdAttribute;
use League\Fractal\TransformerAbstract;

class StatusHistoryTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(StatusHistory $statusHistory): array
    {
        return $this->mergesIdAttribute($statusHistory);
    }
}
