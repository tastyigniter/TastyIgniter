<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\System\Models\Currency;
use League\Fractal\TransformerAbstract;

class CurrencyTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(Currency $currency): array
    {
        return $this->mergesIdAttribute($currency);
    }
}
