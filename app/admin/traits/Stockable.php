<?php

namespace Admin\Traits;

trait Stockable
{
    public static function bootStockable()
    {
        self::extend(function (self $model) {
            $model->relation['morphMany']['stocks'] = [
                \Admin\Models\Stock::class, 'name' => 'stockable', 'delete' => TRUE,
            ];

            $model->appends[] = 'stock_qty';

            $model->addCasts([
                'stock_qty' => 'integer',
            ]);
        });

        self::saved(function (self $model) {
            $model->deleteDetachedStocks();
        });
    }

    public function getStockQtyAttribute()
    {
        return $this->stocks()->sum('quantity');
    }

    //
    //
    //

    public function getStockByLocation($location)
    {
        return $this->stocks()->firstOrCreate([
            'location_id' => is_numeric($location) ? $location : $location->getKey(),
        ]);
    }

    public function outOfStock($location = null)
    {
        $stocks = $this->stocks->where('is_tracked', TRUE);

        if ($stocks->isEmpty())
            return FALSE;

        if (!is_null($location))
            $stocks = $stocks->where('location_id', is_numeric($location) ? $location : $location->getKey());

        $stocks = $stocks->filter(function ($stock) {
            return $stock->outOfStock();
        });

        return $stocks->isNotEmpty();
    }

    public function checkStockLevel($quantity, $location = null)
    {
        $stocks = $this->stocks->where('is_tracked', TRUE);

        if ($stocks->isEmpty())
            return TRUE;

        if (!is_null($location))
            $stocks = $stocks->where('location_id', is_numeric($location) ? $location : $location->getKey());

        return $stocks->sum('quantity') >= $quantity;
    }

    public function deleteDetachedStocks()
    {
        $idsToKeep = $this->hasRelation('locations')
            ? $this->locations()->get()->pluck('location_id')->all()
            : $this->option->locations()->get()->pluck('location_id')->all();

        $this->stocks()
            ->whereNotIn('location_id', $idsToKeep)
            ->delete();
    }
}
