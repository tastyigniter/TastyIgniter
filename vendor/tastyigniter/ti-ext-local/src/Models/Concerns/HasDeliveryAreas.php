<?php

declare(strict_types=1);

namespace Igniter\Local\Models\Concerns;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Local\Models\LocationArea;

trait HasDeliveryAreas
{
    public static function bootHasDeliveryAreas(): void
    {
        static::extend(function(self $model): void {
            $model->relation['hasMany']['delivery_areas'] = [LocationArea::class, 'delete' => true];

            $model->addPurgeable(['delivery_areas']);
        });

        self::saving(function(self $model): void {
            $model->geocodeAddressOnSave();
        });

        self::saved(function(self $model): void {
            $model->restorePurgedValues();

            if (array_key_exists('delivery_areas', $model->getAttributes())) {
                $model->addLocationAreas((array)array_get($model->getAttributes(), 'delivery_areas', []));
            }
        });
    }

    protected function geocodeAddressOnSave()
    {
        if (!$this->is_auto_lat_lng) {
            return;
        }

        $attributesToCheck = [
            'location_address_1',
            'location_address_2',
            'location_city',
            'location_state',
            'location_postcode',
            'location_country_id',
            'location_lat',
            'location_lng',
        ];
        if ($this->location_lat && $this->location_lng && !$this->isDirty($attributesToCheck)) {
            return;
        }

        $address = format_address($this->getAddress(), false);

        $geoLocation = Geocoder::geocode($address)->first();
        if ($geoLocation && $geoLocation->hasCoordinates()) {
            $this->location_lat = $geoLocation->getCoordinates()->getLatitude();
            $this->location_lng = $geoLocation->getCoordinates()->getLongitude();
        }
    }

    public function listDeliveryAreas()
    {
        return $this->delivery_areas->keyBy('area_id');
    }

    public function findDeliveryArea($areaId): ?LocationArea
    {
        return $this->listDeliveryAreas()->get($areaId);
    }

    public function searchOrDefaultDeliveryArea(?CoordinatesInterface $coordinates): ?LocationArea
    {
        if ($coordinates && ($area = $this->searchDeliveryArea($coordinates))) {
            return $area;
        }

        return $this->delivery_areas->where('is_default', 1)->first();
    }

    public function searchOrFirstDeliveryArea(?CoordinatesInterface $coordinates): ?LocationArea
    {
        if ($coordinates && ($area = $this->searchDeliveryArea($coordinates))) {
            return $area;
        }

        return $this->delivery_areas->first();
    }

    public function searchDeliveryArea(CoordinatesInterface $coordinates): ?LocationArea
    {
        return $this->delivery_areas
            ->sortBy('priority')
            ->first(fn(LocationArea $model): bool => $model->checkBoundary($coordinates));
    }

    public function getDistanceUnit(): string
    {
        return strtolower($this->distanceUnit ?? setting('distance_unit'));
    }

    //
    //
    //
    /**
     * Create a new or update existing location areas
     *
     * @param array $deliveryAreas
     */
    public function addLocationAreas($deliveryAreas): int
    {
        $idsToKeep = [];
        foreach ($deliveryAreas ?: [] as $area) {
            $locationArea = $this->delivery_areas()->firstOrNew([
                'area_id' => $area['area_id'] ?? null,
            ])->fill(array_except($area, ['area_id']));

            $locationArea->save();
            $idsToKeep[] = $locationArea->getKey();
        }

        $this->delivery_areas()->whereNotIn('area_id', $idsToKeep)->delete();

        return count($idsToKeep);
    }
}
