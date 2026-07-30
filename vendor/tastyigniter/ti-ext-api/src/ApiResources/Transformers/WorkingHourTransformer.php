<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Local\Models\WorkingHour;
use League\Fractal\TransformerAbstract;

class WorkingHourTransformer extends TransformerAbstract
{
    public function transform(WorkingHour $workingHour)
    {
        return $workingHour->toArray();
    }
}
