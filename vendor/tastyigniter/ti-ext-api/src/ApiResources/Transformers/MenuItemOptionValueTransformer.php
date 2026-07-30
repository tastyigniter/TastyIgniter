<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Flame\Currency\Facades\Currency;
use League\Fractal\TransformerAbstract;

class MenuItemOptionValueTransformer extends TransformerAbstract
{
    public function transform(array|MenuItemOptionValue $menuItemOptionValue): array
    {
        if (!is_array($menuItemOptionValue)) {
            $menuItemOptionValue = $menuItemOptionValue->toArray();
        }

        return array_merge($menuItemOptionValue, [
            'id' => $menuItemOptionValue['menu_option_value_id'],
            'currency' => Currency::getDefault()->currency_code,
        ]);
    }
}
