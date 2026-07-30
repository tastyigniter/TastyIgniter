<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Cart\Models\MenuItemOption;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class MenuItemOptionTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [
        'menu_option_values',
    ];

    public function transform(MenuItemOption $menuItemOption): array
    {
        return array_merge($menuItemOption->toArray(), [
            'id' => $menuItemOption->menu_option_id,
            'option' => $menuItemOption->option,
        ]);
    }

    public function includeMenuOptionValues(MenuItemOption $menuItemOption): Collection
    {
        return $this->collection(
            $menuItemOption->menu_option_values,
            new MenuItemOptionValueTransformer,
            'menu_option_values',
        );
    }
}
