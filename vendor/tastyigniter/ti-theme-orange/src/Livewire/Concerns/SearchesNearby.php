<?php

declare(strict_types=1);

namespace Igniter\Orange\Livewire\Concerns;

use Exception;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\GeoQuery;
use Igniter\Flame\Geolite\Model\Coordinates;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Main\Traits\UsesPage;
use Igniter\System\Facades\Assets;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Livewire;
use Throwable;

/**
 * SearchesNearby trait.
 *
 * @property null|\Igniter\Local\Classes\Location $location
 */
trait SearchesNearby
{
    use UsesPage;

    public ?string $searchQuery = null;

    public ?array $searchPoint = null;

    public string $menusPage = 'local.menus';

    public ?string $deliveryAddress = null;

    #[Session]
    public ?int $savedAddressId = null;

    protected string $searchField = 'searchQuery';

    public array $placesSuggestions = [];

    public string $mapKey = '';

    public bool $searchAutocompleteEnabled = true;

    public bool $isSearching = false;

    public string $geocoder;

    public function definePropertiesSearchNearby(): array
    {
        return [
            'menusPage' => [
                'label' => 'Page to redirect to when a location is found',
                'type' => 'select',
                'options' => static::getThemePageOptions(...),
                'validationRule' => 'required|regex:/^[a-z0-9\-_\.]+$/i',
            ],
            'searchAutocompleteEnabled' => [
                'label' => 'Enable address autocomplete and mark your location option when entering delivery address.',
                'type' => 'switch',
            ],
        ];
    }

    public function mountSearchesNearby(): void
    {
        $this->geocoder = setting('default_geocoder', 'nominatim');
        if ($this->searchAutocompleteEnabled) {
            Assets::addCss('igniter-orange::/css/autocomplete.css', 'autocomplete-css');
            if ($this->geocoder === 'nominatim') {
                Assets::addCss('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', 'leaflet-css');
                Assets::addJs('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', 'leaflet-js');
            } else {
                Assets::addJs('igniter-orange::/js/google-maps.js', 'google-maps-js');
            }
        }

        $this->mapKey = setting('maps_api_key');
        $this->searchQuery = Location::getSession('searchQuery');
        $this->deliveryAddress = Auth::customer()?->address?->formatted_address;
    }

    #[Computed]
    public function savedAddresses(): Collection
    {
        return collect(Auth::customer()->addresses ?? []);
    }

    public function onSearchNearby()
    {
        try {
            $userLocation = $this->geocodeUserPosition();

            Location::updateUserPosition($userLocation);
            Location::putSession('searchQuery', $this->searchQuery);

            $nearByLocation = $this->findNearByLocation($userLocation);

            request()->route()->setParameter('location', $nearByLocation->permalink_slug);

            return $this->redirect(restaurant_url($this->menusPage));
        } catch (Exception $ex) {
            throw ValidationException::withMessages([$this->searchField => $ex->getMessage()]);
        }
    }

    public function onSelectAddress($id)
    {
        $this->searchField = 'savedAddress';

        throw_unless($address = $this->savedAddresses()->firstWhere('address_id', $id), ValidationException::withMessages([
            $this->searchField => lang('igniter.orange::default.alert_saved_address_not_found'),
        ]));

        $searchQuery = format_address($address->toArray(), false);

        $userLocation = $this->geocodeSearchQuery($searchQuery);

        $this->searchQuery = null;

        if (!isset($this->location)) {
            $nearByLocation = $this->findNearByLocation($userLocation);

            request()->route()->setParameter('location', $nearByLocation->permalink_slug);

            return $this->redirect(restaurant_url($this->menusPage));
        }

        if ($area = $this->location->current()->searchDeliveryArea($userLocation->getCoordinates())) {
            $this->location->updateUserPosition($userLocation);
            $this->location->updateNearbyArea($area);
            $this->location->putSession('searchQuery', $searchQuery);
        } else {
            throw ValidationException::withMessages([
                $this->searchField => lang('igniter.local::default.alert_delivery_area_unavailable'),
            ]);
        }

        $this->searchField = 'searchQuery';

        return null;
    }

    #[On('userPositionUpdated')]
    public function onUserPositionUpdated($position = null, $updateMap = false): void
    {
        $this->searchPoint = $position;

        try {
            $this->geocodeUserPosition();
            if ($updateMap && $this->searchAutocompleteEnabled) {
                $this->updatedOrderType();
            }
        } catch (Exception $ex) {
            throw ValidationException::withMessages([$this->searchField => $ex->getMessage()]);
        }
    }

    public function updatedOrderType(): void
    {
        if ($this->orderType && $this->orderType === LocationModel::DELIVERY && $this->searchAutocompleteEnabled) {
            $this->dispatch('updateDeliveryLocationMap',
                lat: $this->searchPoint[0] ?? null,
                lng: $this->searchPoint[1] ?? null,
                geocoder: $this->geocoder);
        }
    }

    public function onUpdateSearchQuery()
    {
        try {
            $userLocation = $this->geocodeUserPosition();

            Location::updateUserPosition($userLocation);
            Location::putSession('searchQuery', $this->searchQuery);
        } catch (Exception $ex) {
            throw ValidationException::withMessages([$this->searchField => $ex->getMessage()]);
        }

        return $this->redirect(Livewire::originalUrl(), navigate: true);
    }

    public function onSelectSuggestion(int $index): void
    {
        $suggestion = $this->placesSuggestions[$index] ?? null;
        if (!$this->searchAutocompleteEnabled || !$suggestion) {
            return;
        }

        $this->isSearching = false;
        $this->searchQuery = $suggestion['title'] ?? null;

        try {
            $placeCoordinates = array_get($suggestion, 'provider') === 'nominatim'
                ? new Coordinates((float)$suggestion['data']['latitude'], (float)$suggestion['data']['longitude'])
                : Geocoder::driver('google')->getPlaceCoordinates(GeoQuery::create($suggestion['placeId']));

            $this->searchPoint = [$placeCoordinates->getLatitude(), $placeCoordinates->getLongitude()];

            $this->dispatch(
                'updateDeliveryLocationMap',
                lat: $this->searchPoint[0],
                lng: $this->searchPoint[1],
                geocoder: $suggestion['provider'],
            );
        } catch (Throwable $e) {
            throw ValidationException::withMessages([$this->searchField => $e->getMessage()]);
        }
    }

    public function onChangeDeliveryAddress(): void
    {
        $this->showAddressPicker = true;
        if (!$this->searchAutocompleteEnabled) {
            return;
        }

        if ($coordinates = Location::userPosition()?->getCoordinates()) {
            $this->searchPoint = [$coordinates->getLatitude(), $coordinates->getLongitude()];
            $this->dispatch(
                'updateDeliveryLocationMap',
                lat: $coordinates->getLatitude(),
                lng: $coordinates->getLongitude(),
                geocoder: $this->geocoder,
            );
        }
    }

    public function updatedSearchQuery(): void
    {
        if (!$this->searchAutocompleteEnabled) {
            return;
        }

        try {
            if (strlen($this->searchQuery) < 3) {
                $this->isSearching = false;
                $this->searchPoint = null;
                $this->dispatch('resetMap');
            } else {
                $this->isSearching = true;
                $query = GeoQuery::create($this->searchQuery);
                $this->placesSuggestions = Geocoder::driver()->placesAutocomplete($query)->toArray();
            }
        } catch (Exception $e) {
            throw ValidationException::withMessages([$this->searchField => $e->getMessage()]);
        }
    }

    protected function getSearchQuery()
    {
        if (!is_null($coordinates = $this->searchPoint)) {
            return $coordinates;
        }

        return $this->searchQuery;
    }

    /**
     * @return GeoliteLocation
     */
    protected function geocodeSearchQuery($searchQuery)
    {
        return $this->handleGeocodeResponse(Geocoder::geocode($searchQuery));
    }

    protected function geocodeSearchPoint($searchPoint)
    {
        throw_if(count(array_filter($searchPoint)) !== 2, ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_no_search_query'),
        ]));

        [$latitude, $longitude] = $searchPoint;

        $collection = Geocoder::reverse($latitude, $longitude);

        $userLocation = $this->handleGeocodeResponse($collection);

        $this->searchQuery = $userLocation->format();

        return $userLocation;
    }

    protected function handleGeocodeResponse($collection)
    {
        if (!$collection || $collection->isEmpty()) {
            Log::error(implode(PHP_EOL, Geocoder::getLogs()));

            throw ValidationException::withMessages([
                $this->searchField => lang('igniter.local::default.alert_invalid_search_query'),
            ]);
        }

        $userLocation = $collection->first();
        if (!$userLocation->hasCoordinates()) {
            throw ValidationException::withMessages([
                $this->searchField => lang('igniter.local::default.alert_invalid_search_query'),
            ]);
        }

        return $userLocation;
    }

    protected function findNearByLocation(GeoliteLocation $userLocation)
    {
        $nearByLocation = Location::searchByCoordinates(
            $userLocation->getCoordinates(),
        )->first(function(LocationModel $location) use ($userLocation) { // @phpstan-ignore-line argument.type
            if (!is_null($area = $location->searchDeliveryArea($userLocation->getCoordinates()))) {
                Location::updateNearbyArea($area);

                return $area;
            }
        });

        throw_unless($nearByLocation, ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_no_found_restaurant'),
        ]));

        return $nearByLocation;
    }

    protected function geocodeUserPosition(): mixed
    {
        throw_unless($searchQuery = $this->getSearchQuery(), ValidationException::withMessages([
            $this->searchField => lang('igniter.local::default.alert_no_search_query'),
        ]));

        return is_array($searchQuery)
            ? $this->geocodeSearchPoint($searchQuery)
            : $this->geocodeSearchQuery($searchQuery);
    }
}
