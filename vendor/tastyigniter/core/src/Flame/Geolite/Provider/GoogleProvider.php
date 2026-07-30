<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Provider;

use GuzzleHttp\Client as HttpClient;
use Igniter\Flame\Geolite\Contracts\AbstractProvider;
use Igniter\Flame\Geolite\Contracts\DistanceInterface;
use Igniter\Flame\Geolite\Contracts\GeoQueryInterface;
use Igniter\Flame\Geolite\Exception\GeoliteException;
use Igniter\Flame\Geolite\Model\Coordinates;
use Igniter\Flame\Geolite\Model\Distance;
use Igniter\Flame\Geolite\Model\Location;
use Igniter\Flame\Geolite\Place;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Override;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class GoogleProvider extends AbstractProvider
{
    public function __construct(HttpClient $client, protected array $config)
    {
        $this->httpClient = $client;
    }

    #[Override]
    public function getName(): string
    {
        return 'Google Maps';
    }

    #[Override]
    public function geocodeQuery(GeoQueryInterface $query): Collection
    {
        $endpoint = array_get($this->config, 'endpoints.geocode');
        $url = $this->prependGeocodeQuery($query, sprintf($endpoint,
            rawurlencode($query->getText()),
        ));

        $result = [];

        try {
            $result = $this->cacheCallback($url, fn(): array => $this->hydrateResponse($this->requestGeocodingUrl($url, $query), $query->getLimit()));
        } catch (Throwable $throwable) {
            $this->log(sprintf(
                'Provider "%s" could not geocode address, "%s".',
                $this->getName(), $throwable->getMessage(),
            ));
        }

        return collect($result);
    }

    #[Override]
    public function reverseQuery(GeoQueryInterface $query): Collection
    {
        $coordinates = $query->getCoordinates();

        $endpoint = array_get($this->config, 'endpoints.reverse');
        $url = $this->prependReverseQuery($query, sprintf($endpoint,
            $coordinates->getLatitude(),
            $coordinates->getLongitude(),
        ));

        $result = [];

        try {
            $result = $this->cacheCallback($url, fn(): array => $this->hydrateResponse($this->requestGeocodingUrl($url, $query), $query->getLimit()));
        } catch (Throwable $throwable) {
            $this->log(sprintf(
                'Provider "%s" could not geocode address, "%s".',
                $this->getName(), $throwable->getMessage(),
            ));
        }

        return collect($result);
    }

    #[Override]
    public function distance(DistanceInterface $distance): ?Distance
    {
        $endpoint = array_get($this->config, 'endpoints.distance');
        $url = $this->prependDistanceQuery($distance, sprintf($endpoint,
            $distance->getFrom()->getLongitude(),
            $distance->getFrom()->getLatitude(),
            $distance->getTo()->getLongitude(),
            $distance->getTo()->getLatitude(),
        ));

        try {
            return $this->cacheCallback($url, function() use ($distance, $url): Distance {
                $response = $this->requestDistanceUrl($url, $distance);

                return new Distance(
                    array_get($response, '0.elements.0.distance.value', 0),
                    array_get($response, '0.elements.0.duration.value', 0),
                );
            });
        } catch (Throwable $throwable) {
            $this->log(sprintf('Provider "%s" could not calculate distance, "%s".',
                $this->getName(), $throwable->getMessage(),
            ));

            return null;
        }
    }

    #[Override]
    public function placesAutocomplete(GeoQueryInterface $query): Collection
    {
        $endpoint = array_get($this->config, 'endpoints.places');
        $url = sprintf($endpoint.':autocomplete?input=%s', rawurlencode($query->getText()));

        try {
            $result = $this->cacheCallback($url, fn(): array => $this->requestPlacesUrl($url, $query));

            return collect(array_get($result, 'suggestions', []))->map(fn($item) => (new Place)
                ->placeId((string)$item['placePrediction']['placeId'])
                ->title((string)$item['placePrediction']['text']['text'])
                ->description((string)$item['placePrediction']['structuredFormat']['secondaryText']['text'])
                ->provider('google'));
        } catch (Throwable $throwable) {
            $this->log(sprintf(
                'Provider "%s" could not fetch place suggestions, "%s".',
                $this->getName(), $throwable->getMessage(),
            ));

            throw $throwable;
        }
    }

    #[Override]
    public function getPlaceCoordinates(GeoQueryInterface $query): Coordinates
    {
        $url = sprintf('%s/%s?sessionToken=%s',
            array_get($this->config, 'endpoints.places'),
            rawurlencode($query->getText()),
            rawurlencode($this->getPlacesSessionToken()),
        );

        try {
            $response = $this->getHttpClient()->get($url, [
                'timeout' => $query->getData('timeout', 15),
                'headers' => [
                    'X-Goog-Api-Key' => array_get($this->config, 'apiKey'),
                    'X-Goog-FieldMask' => implode(',', $query->getData('fieldMask', ['location'])),
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            if ($response->getStatusCode() !== 200) {
                throw new GeoliteException(sprintf('Failed to fetch place details, "%s".', json_encode($result)));
            }

            if (empty($result['location'])) {
                throw new GeoliteException('No location found for this place');
            }

            $this->clearPlacesSessionToken();

            return new Coordinates($result['location']['latitude'], $result['location']['longitude']);
        } catch (Throwable $throwable) {
            $this->log(sprintf(
                'Provider "%s" could not fetch place details, "%s".',
                $this->getName(), $throwable->getMessage(),
            ));

            throw $throwable;
        }
    }

    protected function hydrateResponse(array $response, int $limit): array
    {
        $result = [];
        foreach ($response as $place) {
            $address = new Location($this->getName());

            // set official Google place id
            if ($placeId = array_get($place, 'place_id')) {
                $address->setValue('id', $placeId);
            }

            if ($geometry = array_get($place, 'geometry')) {
                $this->parseCoordinates($address, $geometry);
            }

            if ($addressComponents = array_get($place, 'address_components')) {
                $this->parseAddressComponents($address, $addressComponents);
            }

            if ($formattedAddress = array_get($place, 'formatted_address')) {
                $address->withFormattedAddress($formattedAddress);
            }

            $result[] = $address;
            if (count($result) >= $limit) {
                break;
            }
        }

        return $result;
    }

    protected function requestGeocodingUrl(string $url, GeoQueryInterface $query): array
    {
        if ($locale = $query->getLocale()) {
            $url = sprintf('%s&language=%s', $url, $locale);
        }

        if ($region = $query->getData('region', array_get($this->config, 'region'))) {
            $url = sprintf('%s&region=%s', $url, $region);
        }

        if ($apiKey = array_get($this->config, 'apiKey')) {
            $url = sprintf('%s&key=%s', $url, $apiKey);
        }

        $response = $this->getHttpClient()->get($url, [
            'timeout' => $query->getData('timeout', 15),
        ]);

        return $this->parseResponse($this->validateResponse($response));
    }

    protected function requestDistanceUrl(string $url, DistanceInterface $query): array
    {
        if ($apiKey = array_get($this->config, 'apiKey')) {
            $url = sprintf('%s&key=%s', $url, $apiKey);
        }

        $response = $this->getHttpClient()->get($url, [
            'timeout' => $query->getData('timeout', 15),
        ]);

        return array_get($this->validateResponse($response), 'rows', []);
    }

    protected function requestPlacesUrl(string $url, GeoQueryInterface $query): array
    {
        if ($region = $query->getData('region', array_get($this->config, 'region'))) {
            $params['includedRegionCodes'] = [strtolower((string)$region)];
        }

        $params['sessionToken'] = $this->getPlacesSessionToken();

        $response = $this->getHttpClient()->post($url, [
            'json' => $params,
            'timeout' => $query->getData('timeout', 15),
            'headers' => [
                'X-Goog-Api-Key' => array_get($this->config, 'apiKey'),
                'X-Goog-FieldMask' => implode(',', $query->getData('fieldMask', [
                    'suggestions.placePrediction.placeId',
                    'suggestions.placePrediction.text.text',
                    'suggestions.placePrediction.structuredFormat.secondaryText.text',
                ])),
            ],
        ]);

        return $this->validateResponse($response);
    }

    //
    //
    //

    protected function validateResponse(ResponseInterface $response): array
    {
        $json = json_decode($response->getBody()->getContents(), true);

        // API error
        if (!$json) {
            throw new GeoliteException('The geocoder server returned an empty or invalid response.');
        }

        if (array_get($json, 'status') === 'REQUEST_DENIED') {
            throw new GeoliteException(sprintf(
                'API access denied. Message: %s', array_get($json, 'error_message') ?? 'empty error message',
            ));
        }

        // you are over your quota
        if (array_get($json, 'status') === 'OVER_QUERY_LIMIT') {
            throw new GeoliteException(sprintf(
                'Daily quota exceeded. Message: %s', array_get($json, 'error_message') ?? 'empty error message',
            ));
        }

        return $json;
    }

    /**
     * Decode the response content and validate it to make sure it does not have any errors.
     */
    protected function parseResponse(array $json): array
    {
        $response = array_get($json, 'results', array_get($json, 'rows', []));
        if (!count($response) || array_get($json, 'status') !== 'OK') {
            throw new GeoliteException(array_get($json, 'error_message', 'empty error message'));
        }

        return $response;
    }

    protected function prependGeocodeQuery(GeoQueryInterface $query, string $url): string
    {
        if (!is_null($bounds = $query->getBounds())) {
            $url .= sprintf('&bounds=%s,%s|%s,%s',
                $bounds->getSouth(), $bounds->getWest(),
                $bounds->getNorth(), $bounds->getEast(),
            );
        }

        if ($components = $query->getData('components')) {
            $url .= sprintf('&components=%s',
                urlencode($this->serializeComponents($components)),
            );
        }

        return $url;
    }

    protected function prependReverseQuery(GeoQueryInterface $query, string $url): string
    {
        if ($locationType = $query->getData('location_type')) {
            $url .= '&location_type='.urlencode((string)$locationType);
        }

        if ($resultType = $query->getData('result_type')) {
            $url .= '&result_type='.urlencode((string)$resultType);
        }

        return $url;
    }

    protected function prependDistanceQuery(DistanceInterface $distance, string $url): string
    {
        if ($mode = $distance->getData('mode')) {
            $url .= '&mode='.urlencode((string)$mode);
        }

        if ($region = $distance->getData('region', array_get($this->config, 'region'))) {
            $url .= '&region='.urlencode((string)$region);
        }

        if ($language = $distance->getData('language', array_get($this->config, 'locale'))) {
            $url .= '&language='.urlencode((string)$language);
        }

        $units = $distance->getUnit();

        if (!empty($units)) {
            $url .= '&units='.urlencode($units);
        }

        if ($avoid = $distance->getData('avoid')) {
            $url .= '&avoid='.urlencode((string)$avoid);
        }

        if ($departureTime = $distance->getData('departure_time')) {
            $url .= '&departure_time='.urlencode((string)$departureTime);
        }

        if ($arrivalTime = $distance->getData('arrival_time')) {
            $url .= '&arrival_time='.urlencode((string)$arrivalTime);
        }

        return $url;
    }

    protected function parseCoordinates(Location $address, array $geometry)
    {
        $address->setCoordinates(array_get($geometry, 'location.lat'), array_get($geometry, 'location.lng'));

        if ($bounds = array_get($geometry, 'bounds')) {
            $address->setBounds(
                array_get($bounds, 'southwest.lat'),
                array_get($bounds, 'southwest.lng'),
                array_get($bounds, 'northeast.lat'),
                array_get($bounds, 'northeast.lng'),
            );
        } elseif ($viewport = array_get($geometry, 'viewport')) {
            $address->setBounds(
                array_get($viewport, 'southwest.lat'),
                array_get($viewport, 'southwest.lng'),
                array_get($viewport, 'northeast.lat'),
                array_get($viewport, 'northeast.lng'),
            );
        } elseif (array_get($geometry, 'location_type') === 'ROOFTOP') {
            // Fake bounds
            $address->setBounds(
                array_get($geometry, 'location.lat'),
                array_get($geometry, 'location.lng'),
                array_get($geometry, 'location.lat'),
                array_get($geometry, 'location.lng'),
            );
        }
    }

    protected function parseAddressComponents(Location $address, array $components)
    {
        foreach ($components as $component) {
            foreach (array_get($component, 'types', []) as $type) {
                $this->parseAddressComponent($address, $type, $component);
            }
        }
    }

    protected function parseAddressComponent(Location $address, string $type, array $component): Location
    {
        switch ($type) {
            case 'postal_code':
                return $address->setPostalCode(array_get($component, 'long_name'));
            case 'locality':
            case 'postal_town':
                return $address->setLocality(array_get($component, 'long_name'));
            case 'administrative_area_level_1':
            case 'administrative_area_level_2':
            case 'administrative_area_level_3':
            case 'administrative_area_level_4':
            case 'administrative_area_level_5':
                return $address->addAdminLevel(
                    (int)substr($type, -1),
                    array_get($component, 'long_name', ''),
                    array_get($component, 'short_name'),
                );
            case 'sublocality_level_1':
            case 'sublocality_level_2':
            case 'sublocality_level_3':
            case 'sublocality_level_4':
            case 'sublocality_level_5':
                $subLocalityLevel = $address->getValue('subLocalityLevel', []);
                $subLocalityLevel[] = [
                    'level' => (int)substr($type, -1),
                    'name' => array_get($component, 'long_name'),
                    'code' => array_get($component, 'short_name'),
                ];

                return $address->setValue('subLocalityLevel', $subLocalityLevel);
            case 'country':
                $address->setCountryName(array_get($component, 'long_name'));

                return $address->setCountryCode(array_get($component, 'short_name'));
            case 'street_number':
                return $address->setStreetNumber(array_get($component, 'long_name'));
            case 'route':
                return $address->setStreetName(array_get($component, 'long_name'));
            case 'sublocality':
                return $address->setSubLocality(array_get($component, 'long_name'));
            case 'street_address':
            case 'intersection':
            case 'political':
            case 'colloquial_area':
            case 'ward':
            case 'neighborhood':
            case 'premise':
            case 'subpremise':
            case 'natural_feature':
            case 'airport':
            case 'park':
            case 'point_of_interest':
            case 'establishment':
                return $address->setValue($type, array_get($component, 'long_name'));
            default:
        }

        return $address;
    }

    protected function serializeComponents(string|array $components): string
    {
        if (is_string($components)) {
            return $components;
        }

        return implode('|', array_map(fn(string $name, $value): string => sprintf('%s:%s', $name, $value), array_keys($components), $components));
    }

    protected function getPlacesSessionToken(): string
    {
        $sessionTokenExpiry = Session::get('gm_places_session_token_expires_at');
        if (!$sessionTokenExpiry || $sessionTokenExpiry->isPast()) {
            $sessionToken = Str::uuid()->toString();
            Session::put('gm_places_session_token', $sessionToken);
            Session::put('gm_places_session_token_expires_at', now()->addMinutes(5));
        } else {
            $sessionToken = Session::get('gm_places_session_token');
        }

        return $sessionToken;
    }

    protected function clearPlacesSessionToken(): void
    {
        Session::forget(['gm_places_session_token', 'gm_places_session_token_expires_at']);
    }
}
