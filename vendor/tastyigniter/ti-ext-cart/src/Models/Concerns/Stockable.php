<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Concerns;

use Igniter\Cart\Models\Stock;

trait Stockable
{
    public static function bootStockable(): void
    {
        self::extend(function(self $model): void {
            $model->relation['morphMany']['stocks'] = [
                Stock::class, 'name' => 'stockable', 'delete' => true,
            ];

            $model->appends[] = 'stock_qty';

            $model->addCasts([
                'stock_qty' => 'integer',
            ]);
        });
    }

    public function getStockQtyAttribute()
    {
        return $this->getTrackableStocks()->sum('quantity');
    }

    //
    //
    //

    public function getStockableLocations()
    {
        return $this->locations;
    }

    public function getStockableName()
    {
        return $this->menu_name;
    }

    public function getTrackableStocks($location = null)
    {
        return $this->getAvailableStocks($location)->where('is_tracked', true);
    }

    public function getAvailableStocks($location = null)
    {
        if (!is_null($location)) {
            return $this->stocks->where('location_id', is_numeric($location) ? $location : $location->getKey());
        }

        $locations = $this->getStockableLocations();
        if ($locations && $ids = $locations->pluck('location_id')->all()) {
            return $this->stocks->whereIn('location_id', $ids);
        }

        return $this->stocks;
    }

    public function getStockByLocation($location): Stock
    {
        return $this->stocks()->firstOrCreate([
            'location_id' => is_numeric($location) ? $location : $location->getKey(),
        ]);
    }

    public function outOfStock($location = null)
    {
        $stocks = $this->getTrackableStocks($location);

        if ($stocks->isEmpty()) {
            return false;
        }

        return $stocks->filter(fn($stock) => $stock->outOfStock())->isNotEmpty();
    }

    public function checkStockLevel($quantity, $location = null)
    {
        $stocks = $this->getTrackableStocks($location);

        if ($stocks->isEmpty()) {
            return true;
        }

        return $stocks->sum('quantity') >= $quantity;
    }
}
