<?php

namespace System\Libraries;

use System\Models\Country;

/**
 * Country Class
 */
class Country
{
    const ISO_CODE_2 = 2;

    const ISO_CODE_3 = 3;

    protected $defaultFormat = [
        "{address_1}\n{address_2}\n{city} {postcode}\n{state}\n{country}",
    ];

    protected $requiredAddressKeys = [
        'address_1',
        'address_2',
        'city',
        'postcode',
        'state',
        'country',
    ];

    protected $countriesCollection = [];

    public function addressFormat($address, $useLineBreaks = TRUE)
    {
        $format = $this->getDefaultFormat();

        $address = $this->evalAddress($address);

        // Override format if present in address array
        if (!empty($address['format']))
            $format = $address['format'];

        $formattedAddress = str_replace(['\r\n', '\r', '\n'], '<br />',
            preg_replace(['/\s\s+/', '/\r\r+/', '/\n\n+/'], '<br />',
                trim(str_replace([
                    '{address_1}', '{address_2}', '{city}', '{postcode}', '{state}', '{country}',
                ], array_except($address, 'format'), $format))
            )
        );

        if (!$useLineBreaks)
            $formattedAddress = str_replace('<br />', ', ', $formattedAddress);

        return $formattedAddress;
    }

    public function getCountryNameById($id = null)
    {
        $this->loadCountries();

        if (!$countryModel = $this->countriesCollection->find($id))
            return null;

        return $countryModel->country_name;
    }

    public function getCountryCodeById($id = null, $codeType = null)
    {
        $this->loadCountries();

        if (!$countryModel = $this->countriesCollection->where('country_id', $id)->first())
            return null;

        return (is_null($codeType) || $codeType == static::ISO_CODE_2)
            ? $countryModel->iso_code_2 : $countryModel->iso_code_3;
    }

    public function getCountryNameByCode($isoCodeTwo)
    {
        $this->loadCountries();

        if (!$countryModel = $this->countriesCollection->where('iso_code_2', $isoCodeTwo)->first())
            return null;

        return $countryModel->country_name;
    }

    public function getDefaultFormat()
    {
        if ($defaultCountry = Countries_model::getDefault())
            return $defaultCountry->format;

        return $this->defaultFormat;
    }

    public function listAll($column = null, $key = 'country_id')
    {
        $this->loadCountries();

        if (is_null($column))
            return $this->countriesCollection;

        return $this->countriesCollection->pluck($column, $key);
    }

    protected function evalAddress($address)
    {
        if (isset($address['country_id']) && !isset($address['country']))
            $address['country'] = $address['country_id'];

        $result = [];
        foreach ($this->requiredAddressKeys as $key) {
            if ($key == 'country') {
                $this->processCountryValue($address[$key], $result);
            }
            else {
                $result[$key] = $address[$key] ?? '';
            }
        }

        return $result;
    }

    protected function processCountryValue($country, &$result)
    {
        if (!is_string($country) && isset($country['country_name'])) {
            $result['country'] = $country['country_name'];
            $result['format'] = $country['format'];
        }
        elseif (is_numeric($country)) {
            $this->loadCountries();

            if ($countryModel = $this->countriesCollection->find($country)) {
                $result['country'] = $countryModel->country_name;
                $result['format'] = $countryModel->format;
            }
        }
    }

    protected function loadCountries()
    {
        if (!count($this->countriesCollection))
            $this->countriesCollection = Country::isEnabled()->sorted()->get();

        return $this->countriesCollection;
    }
}
