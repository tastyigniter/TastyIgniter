<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Cart\Models\Menu;
use Igniter\Flame\Currency\Facades\Currency;
use Igniter\Flame\Database\Attach\Media;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class MenuTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'media',
        'categories',
        'menu_options',
        'ingredients',
        'mealtimes',
        'stocks',
    ];

    public function transform(Menu $menuItem): array
    {
        return $this->mergesIdAttribute($menuItem, [
            'currency' => Currency::getDefault()->currency_code,
        ]);
    }

    public function includeMedia(Menu $menuItem): ?Item
    {
        $thumb = $menuItem->getFirstMedia();

        return ($thumb instanceof Media) ? $this->item($thumb, new MediaTransformer, 'media') : null;
    }

    public function includeCategories(Menu $menuItem): ?Collection
    {
        return $this->collection(
            $menuItem->categories,
            new CategoryTransformer,
            'categories',
        );
    }

    public function includeMenuOptions(Menu $menuItem): ?Collection
    {
        return $this->collection(
            $menuItem->menu_options,
            new MenuItemOptionTransformer,
            'menu_options',
        );
    }

    public function includeIngredients(Menu $menuItem): ?Collection
    {
        return $this->collection(
            $menuItem->ingredients,
            new IngredientTransformer,
            'ingredients',
        );
    }

    public function includeMealtimes(Menu $menuItem): ?Collection
    {
        return $this->collection(
            $menuItem->mealtimes,
            new MealtimeTransformer,
            'mealtimes',
        );
    }

    public function includeStocks(Menu $menuItem): ?Collection
    {
        return $this->collection(
            $menuItem->stocks,
            new StockTransformer,
            'stocks',
        );
    }
}
