<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Flame\Currency\Facades\Currency;
use League\Fractal\TransformerAbstract;

class MenuOptionValueTransformer extends TransformerAbstract
{
    public function transform(array|MenuOptionValue $menuOptionValue): array
    {
        if (!is_array($menuOptionValue)) {
            $menuOptionValue = $menuOptionValue->toArray();
        }

        return array_merge($menuOptionValue, [
            'id' => $menuOptionValue['option_value_id'],
            'currency' => Currency::getDefault()->currency_code,
        ]);
    }
}
