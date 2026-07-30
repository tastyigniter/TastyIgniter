<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Cart\Models\MenuOption;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class MenuOptionTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [
        'option_values',
    ];

    public function transform(MenuOption $menuOption): array
    {
        return array_merge($menuOption->toArray(), [
            'id' => $menuOption->option_id,
        ]);
    }

    public function includeOptionValues(MenuOption $menuOption): Collection
    {
        return $this->collection(
            $menuOption->option_values,
            new MenuOptionValueTransformer,
            'option_values',
        );
    }
}
