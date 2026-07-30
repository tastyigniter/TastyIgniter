<?php

declare(strict_types=1);

namespace Igniter\System\Libraries;

use Igniter\System\Models\Country as CountryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Country Class
 */
class Country
{
    public const int ISO_CODE_2 = 2;

    public const int ISO_CODE_3 = 3;

    protected string $defaultFormat = "{address_1}\r\n{address_2}\r\n{city} {postcode}\r\n{state}\r\n{country}";

    protected array $requiredAddressKeys = [
        'address_1',
        'address_2',
        'city',
        'postcode',
        'state',
        'country',
    ];

    protected ?Collection $countriesCollection = null;

    public function addressFormat(array|Model $address, bool $useLineBreaks = true): string
    {
        $format = $this->getDefaultFormat();

        if ($address instanceof Model) {
            $address = $address->toArray();
        }

        // Override format if present in address array
        if (!empty($address['format'])) {
            $format = $address['format'];
        }

        $address = $this->evalAddress($address);

        $formattedAddress = str_replace(["\r\n", "\r", "\n", '\n'], '<br />',
            preg_replace(["/\s\s+/", "/\r\r+/", "/\n\n+/"], '<br />', trim(str_replace([
                '{address_1}', '{address_2}', '{city}', '{postcode}', '{state}', '{country}',
            ], array_except($address, 'format'), $format))),
        );

        if (!$useLineBreaks) {
            $formattedAddress = str_replace(['<br />', '<br>', '<br/>'], ', ', $formattedAddress);
        }

        return strip_tags($formattedAddress, '<br>');
    }

    public function getCountryNameById(null|int|string $id = null): ?string
    {
        $this->loadCountries();

        /** @var CountryModel $countryModel */
        if (!$countryModel = $this->countriesCollection->get($id)) {
            return null;
        }

        return $countryModel->country_name;
    }

    public function getCountryCodeById(null|int|string $id = null, ?int $codeType = null): ?string
    {
        $this->loadCountries();

        /** @var CountryModel $countryModel */
        if (!$countryModel = $this->countriesCollection->get($id)) {
            return null;
        }

        return (is_null($codeType) || $codeType === static::ISO_CODE_2)
            ? $countryModel->iso_code_2 : $countryModel->iso_code_3;
    }

    public function getCountryNameByCode(string $isoCodeTwo): ?string
    {
        $this->loadCountries();

        /** @var CountryModel $countryModel */
        if (!$countryModel = $this->countriesCollection->firstWhere('iso_code_2', $isoCodeTwo)) {
            return null;
        }

        return $countryModel->country_name;
    }

    public function getDefaultFormat(): string
    {
        return CountryModel::getDefault()?->format ?: $this->defaultFormat;
    }

    public function listAll(?string $column = null, string $key = 'country_id'): Collection
    {
        $this->loadCountries();

        if (is_null($column)) {
            return $this->countriesCollection;
        }

        return $this->countriesCollection->pluck($column, $key);
    }

    protected function evalAddress(array $address): array
    {
        if (isset($address['country_id']) && !isset($address['country'])) {
            $address['country'] = $address['country_id'];
        }

        $result = [];
        foreach ($this->requiredAddressKeys as $key) {
            if ($key == 'country') {
                $this->processCountryValue($address[$key] ?? '', $result);
            } else {
                $result[$key] = $address[$key] ?? '';
            }
        }

        return $result;
    }

    protected function processCountryValue(int|string|array $country, array &$result)
    {
        if (is_array($country) && isset($country['country_name'])) {
            $result['country'] = $country['country_name'];
            $result['format'] = $country['format'];
        } elseif (is_numeric($country)) {
            $this->loadCountries();

            /** @var CountryModel $countryModel */
            if ($countryModel = $this->countriesCollection->get($country)) {
                $result['country'] = $countryModel->country_name;
                $result['format'] = $countryModel->format;
            }
        } elseif (is_string($country)) {
            $result['country'] = $country;
        }
    }

    protected function loadCountries(): Collection
    {
        if (is_null($this->countriesCollection)) {
            $this->countriesCollection = collect(CountryModel::query()->whereIsEnabled()->sorted()->get()->keyBy('country_id'));
        }

        return $this->countriesCollection;
    }
}
