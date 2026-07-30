<?php

declare(strict_types=1);

namespace Igniter\Local\Models\Concerns;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Contracts\DistanceInterface;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Facades\Geolite;
use Igniter\Flame\Geolite\Model\Distance;
use Igniter\Local\Models\LocationSettings;

trait LocationHelpers
{
    public function getName()
    {
        return $this->location_name;
    }

    public function getEmail(): string
    {
        return strtolower($this->location_email);
    }

    public function getTelephone()
    {
        return $this->location_telephone;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAddress(): array
    {
        $country = optional($this->country);

        return [
            'address_1' => $this->location_address_1,
            'address_2' => $this->location_address_2,
            'city' => $this->location_city,
            'state' => $this->location_state,
            'postcode' => $this->location_postcode,
            'location_lat' => $this->location_lat,
            'location_lng' => $this->location_lng,
            'country_id' => $this->location_country_id,
            'country' => $country->country_name,
            'iso_code_2' => $country->iso_code_2,
            'iso_code_3' => $country->iso_code_3,
            'format' => $country->format,
        ];
    }

    public function calculateDistance(CoordinatesInterface $position): ?Distance
    {
        $distance = $this->makeDistance();

        $distance->setFrom($this->getCoordinates());
        $distance->setTo($position);
        $distance->in($this->getDistanceUnit());

        return Geocoder::driver()->distance($distance);
    }

    public function getCoordinates(): CoordinatesInterface
    {
        return Geolite::coordinates($this->location_lat, $this->location_lng);
    }

    public function makeDistance(): DistanceInterface
    {
        return Geolite::distance();
    }

    public function setUrl($suffix = null): void
    {
        if (is_single_location()) {
            $suffix = '/menus';
        }

        $this->url = page_url($this->permalink_slug.$suffix);
    }

    public function hasGallery()
    {
        return $this->hasMedia('gallery');
    }

    public function getGallery()
    {
        return $this->getMedia('gallery');
    }

    public function getSettings(string $item, mixed $default = null): mixed
    {
        return array_get($this->grouped_settings, $item, $default);
    }

    public function findSettings(string $item): LocationSettings
    {
        return $this->settings()->firstOrNew(['item' => $item]);
    }

    public function getGroupedSettingsAttribute(): mixed
    {
        return $this->settings->mapWithKeys(fn($setting): array => [$setting->item => $setting->data])->all();
    }
}
