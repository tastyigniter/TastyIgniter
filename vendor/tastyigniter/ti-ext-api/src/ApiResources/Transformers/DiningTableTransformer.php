<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Reservation\Models\DiningTable;
use League\Fractal\TransformerAbstract;

class DiningTableTransformer extends TransformerAbstract
{
    public function transform(DiningTable $table)
    {
        return $table->toArray();
    }
}
