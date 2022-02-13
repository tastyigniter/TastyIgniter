<?php

namespace Admin\Traits;

use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Location\Contracts\AreaInterface;

trait HasDeliveryAreas
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $deliveryAreas;

    public static function bootHasDeliveryAreas()
    {
        static::fetched(function (self $model) {
            $value = @json_decode($model->attributes['options'], TRUE) ?: [];

            $model->parseAreasFromOptions($value);

            $model->attributes['options'] = @json_encode($value);
        });

        static::saving(function (self $model) {
            $model->geocodeAddressOnSave();

            $value = @json_decode($model->attributes['options'], TRUE) ?: [];

            $model->parseAreasFromOptions($value);

            $model->attributes['options'] = @json_encode($value);
        });
    }

    protected function geocodeAddressOnSave()
    {
        if (!array_get($this->options, 'auto_lat_lng', TRUE))
            return;

        if (!$this->isDirty([
            'location_address_1',
            'location_address_2',
            'location_city',
            'location_state',
            'location_postcode',
            'location_country_id',
        ])) return;

        $address = format_address($this->getAddress(), FALSE);

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

    /**
     * @param $areaId
     *
     * @return \Igniter\Flame\Location\Contracts\AreaInterface|null
     */
    public function findDeliveryArea($areaId)
    {
        return $this->listDeliveryAreas()->get($areaId);
    }

    /**
     * @param \Igniter\Flame\Geolite\Contracts\CoordinatesInterface $coordinates
     * @return \Igniter\Flame\Location\Contracts\AreaInterface|null
     */
    public function searchOrDefaultDeliveryArea($coordinates)
    {
        if ($area = $this->searchDeliveryArea($coordinates))
            return $area;

        return $this->delivery_areas->where('is_default', 1)->first();
    }

    /**
     * @param \Igniter\Flame\Geolite\Contracts\CoordinatesInterface $coordinates
     * @return \Igniter\Flame\Location\Contracts\AreaInterface|null
     */
    public function searchOrFirstDeliveryArea($coordinates)
    {
        if (!$area = $this->searchDeliveryArea($coordinates))
            $area = $this->delivery_areas->first();

        return $area;
    }

    /**
     * @param \Igniter\Flame\Geolite\Contracts\CoordinatesInterface $coordinates
     * @return \Igniter\Flame\Location\Contracts\AreaInterface|null
     */
    public function searchDeliveryArea($coordinates)
    {
        if (!$coordinates)
            return null;

        return $this->delivery_areas
            ->sortBy('priority')
            ->first(function (AreaInterface $model) use ($coordinates) {
                return $model->checkBoundary($coordinates);
            });
    }

    public function getDistanceUnit()
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
     *
     * @return bool
     */
    public function addLocationAreas($deliveryAreas)
    {
        $locationId = $this->getKey();
        if (!is_numeric($locationId))
            return FALSE;

        if (!is_array($deliveryAreas))
            return FALSE;

        $idsToKeep = [];
        foreach ($deliveryAreas as $area) {
            $locationArea = $this->delivery_areas()->firstOrNew([
                'area_id' => $area['area_id'] ?? null,
            ])->fill(array_except($area, ['area_id']));

            $locationArea->save();
            $idsToKeep[] = $locationArea->getKey();
        }

        $this->delivery_areas()->whereNotIn('area_id', $idsToKeep)->delete();

        return count($idsToKeep);
    }

    protected function parseAreasFromOptions(&$value)
    {
        // Rename options array index ['delivery_areas']['charge']
        // to ['delivery_areas']['conditions']
        if (isset($value['delivery_areas'])) {
            foreach ($value['delivery_areas'] as &$area) {
                if (!isset($charge['charge'])) continue;
                $area['conditions'] = is_array($area['charge']) ? $area['charge'] : [];
                foreach ($area['conditions'] as $id => &$charge) {
                    if (!isset($charge['condition'])) continue;
                    $charge['type'] = $charge['condition'];
                    unset($charge['condition']);
                }
                unset($area['charge']);
            }
        }
    }
}
