<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Group of standard measurement units.
 */
class StandardUnitDescriptionGroup implements \JsonSerializable
{
    /**
     * @var array
     */
    private $standardUnitDescriptions = [];

    /**
     * @var array
     */
    private $languageCode = [];

    /**
     * Returns Standard Unit Descriptions.
     * List of standard (non-custom) measurement units in this description group.
     *
     * @return StandardUnitDescription[]|null
     */
    public function getStandardUnitDescriptions(): ?array
    {
        if (count($this->standardUnitDescriptions) == 0) {
            return null;
        }
        return $this->standardUnitDescriptions['value'];
    }

    /**
     * Sets Standard Unit Descriptions.
     * List of standard (non-custom) measurement units in this description group.
     *
     * @maps standard_unit_descriptions
     *
     * @param StandardUnitDescription[]|null $standardUnitDescriptions
     */
    public function setStandardUnitDescriptions(?array $standardUnitDescriptions): void
    {
        $this->standardUnitDescriptions['value'] = $standardUnitDescriptions;
    }

    /**
     * Unsets Standard Unit Descriptions.
     * List of standard (non-custom) measurement units in this description group.
     */
    public function unsetStandardUnitDescriptions(): void
    {
        $this->standardUnitDescriptions = [];
    }

    /**
     * Returns Language Code.
     * IETF language tag.
     */
    public function getLanguageCode(): ?string
    {
        if (count($this->languageCode) == 0) {
            return null;
        }
        return $this->languageCode['value'];
    }

    /**
     * Sets Language Code.
     * IETF language tag.
     *
     * @maps language_code
     */
    public function setLanguageCode(?string $languageCode): void
    {
        $this->languageCode['value'] = $languageCode;
    }

    /**
     * Unsets Language Code.
     * IETF language tag.
     */
    public function unsetLanguageCode(): void
    {
        $this->languageCode = [];
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (!empty($this->standardUnitDescriptions)) {
            $json['standard_unit_descriptions'] = $this->standardUnitDescriptions['value'];
        }
        if (!empty($this->languageCode)) {
            $json['language_code']              = $this->languageCode['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
