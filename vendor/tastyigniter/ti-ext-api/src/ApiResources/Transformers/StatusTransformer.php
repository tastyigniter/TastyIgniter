<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Admin\Models\Status;
use Igniter\Api\Traits\MergesIdAttribute;
use League\Fractal\TransformerAbstract;

class StatusTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(Status $status): array
    {
        return $this->mergesIdAttribute($status);
    }
}
